Slotmachine.window.CreateRequest = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'slotmachine-request-window-create';
    }
    Ext.applyIf(config, {
        title: _('slotmachine_request_create'),
        width: 550,
        autoHeight: true,
        url: Slotmachine.config.connector_url,
        action: 'mgr/request/create',
        fields: this.getFields(config),
        keys: [
            {
                key: Ext.EventObject.ENTER, shift: true, fn: function() {
                this.submit();
            }, scope: this,
            }],
    });
    Slotmachine.window.CreateRequest.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine.window.CreateRequest, MODx.Window, {

    getFields: function(config) {
        return [
            {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_office'),
                name: 'office',
                id: config.id + '-office',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_email'),
                name: 'email',
                id: config.id + '-email',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_code'),
                name: 'code',
                id: config.id + '-code',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_gift'),
                name: 'gift',
                id: config.id + '-gift',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('slotmachine_request_active'),
                name: 'active',
                id: config.id + '-active',
                checked: true,
            }];
    },

    loadDropZones: function() {
    },

});
Ext.reg('slotmachine-request-window-create', Slotmachine.window.CreateRequest);

Slotmachine.window.UpdateRequest = function(config) {
    config = config || {};
    if (!config.id) {
        config.id = 'slotmachine-request-window-update';
    }
    Ext.applyIf(config, {
        title: _('slotmachine_request_update'),
        width: 550,
        autoHeight: true,
        url: Slotmachine.config.connector_url,
        action: 'mgr/request/update',
        fields: this.getFields(config),
        keys: [
            {
                key: Ext.EventObject.ENTER, shift: true, fn: function() {
                this.submit();
            }, scope: this,
            }],
    });
    Slotmachine.window.UpdateRequest.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine.window.UpdateRequest, MODx.Window, {

    getFields: function(config) {
        return [
            {
                xtype: 'hidden',
                name: 'id',
                id: config.id + '-id',
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_office'),
                name: 'office',
                id: config.id + '-office',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_email'),
                name: 'email',
                id: config.id + '-email',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_code'),
                name: 'code',
                id: config.id + '-code',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'textfield',
                fieldLabel: _('slotmachine_request_gift'),
                name: 'gift',
                id: config.id + '-gift',
                anchor: '99%',
                allowBlank: false,
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('slotmachine_request_active'),
                name: 'active',
                id: config.id + '-active'
            }];
    },

    loadDropZones: function() {
    },

});
Ext.reg('slotmachine-request-window-update', Slotmachine.window.UpdateRequest);