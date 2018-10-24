Slotmachine.grid.Requests = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'slotmachine-grid-requests';
    }
    Ext.applyIf(config, {
        url: Slotmachine.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/request/getlist',
        },
        listeners: {
            rowDblClick: function(grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateRequest(grid, e, row);
            },
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function(rec) {
                return !rec.data.active
                    ? 'slotmachine-grid-row-disabled'
                    : '';
            },
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    Slotmachine.grid.Requests.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function() {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(Slotmachine.grid.Requests, MODx.grid.Grid, {
    windows: {},

    getMenu: function(grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = Slotmachine.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createRequest: function(btn, e) {
        var w = MODx.load({
            xtype: 'slotmachine-request-window-create',
            id: Ext.id(),
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    }, scope: this,
                },
            },
        });
        w.reset();
        w.setValues({active: true});
        w.show(e.target);
    },

    updateRequest: function(btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/request/get',
                id: id,
            },
            listeners: {
                success: {
                    fn: function(r) {
                        var w = MODx.load({
                            xtype: 'slotmachine-request-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function() {
                                        this.refresh();
                                    }, scope: this,
                                },
                            },
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this,
                },
            },
        });
    },

    removeRequest: function() {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('slotmachine_requests_remove')
                : _('slotmachine_request_remove'),
            text: ids.length > 1
                ? _('slotmachine_requests_remove_confirm')
                : _('slotmachine_request_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/request/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    }, scope: this,
                },
            },
        });
        return true;
    },

    disableRequest: function() {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/request/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    }, scope: this,
                },
            },
        });
    },

    enableRequest: function() {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/request/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    }, scope: this,
                },
            },
        });
    },

    getFields: function() {
        return ['id', 'office', 'email', 'code', 'gift', 'active', 'actions'];
    },

    getColumns: function() {
        return [
            {
                header: _('slotmachine_request_id'),
                dataIndex: 'id',
                sortable: true,
                width: 60,
            }, {
                header: _('slotmachine_request_office'),
                dataIndex: 'office',
                sortable: true,
                width: 200,
            }, {
                header: _('slotmachine_request_email'),
                dataIndex: 'email',
                sortable: false,
                width: 200,
            }, {
                header: _('slotmachine_request_code'),
                dataIndex: 'code',
                sortable: true,
                width: 200,
            }, {
                header: _('slotmachine_request_gift'),
                dataIndex: 'gift',
                sortable: true,
                width: 200,
            }, {
                header: _('slotmachine_request_active'),
                dataIndex: 'active',
                renderer: Slotmachine.utils.renderBoolean,
                sortable: true,
                width: 100,
            }/* {
        header: _('slotmachine_grid_actions'),
        dataIndex: 'actions',
        renderer: Slotmachine.utils.renderActions,
        sortable: false,
        width: 100,
        id: 'actions',
      }*/];
    },

    getTopBar: function() {
        return [
            {
                text: '<i class="icon icon-plus"></i>&nbsp;' +
                _('slotmachine_request_create'),
                handler: this.createRequest,
                scope: this,
            }, '->', {
                xtype: 'slotmachine-field-search',
                width: 250,
                listeners: {
                    search: {
                        fn: function(field) {
                            this._doSearch(field);
                        }, scope: this,
                    },
                    clear: {
                        fn: function(field) {
                            field.setValue('');
                            this._clearSearch();
                        }, scope: this,
                    },
                },
            }];
    },

    onClick: function(e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function() {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function(tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function() {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('slotmachine-grid-requests', Slotmachine.grid.Requests);
