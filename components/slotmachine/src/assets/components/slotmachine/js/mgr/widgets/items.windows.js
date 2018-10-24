Slotmachine.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'slotmachine-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('slotmachine_item_create'),
        width: 550,
        autoHeight: true,
        url: Slotmachine.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Slotmachine.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('slotmachine_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('slotmachine_item_image'),
            name: 'image',
            id: config.id + '-image',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'slotmachine-combo-chance',
            fieldLabel: _('slotmachine_item_chance'),
            name: 'chance',
            hiddenName: 'chance',
            id: config.id + '-chance',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('slotmachine_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('slotmachine-item-window-create', Slotmachine.window.CreateItem);


Slotmachine.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'slotmachine-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('slotmachine_item_update'),
        width: 550,
        autoHeight: true,
        url: Slotmachine.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    Slotmachine.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype: 'textfield',
            fieldLabel: _('slotmachine_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'modx-combo-browser',
            fieldLabel: _('slotmachine_item_image'),
            name: 'image',
            id: config.id + '-image',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'slotmachine-combo-chance',
            fieldLabel: _('slotmachine_item_chance'),
            name: 'chance',
            hiddenName: 'chance',
            id: config.id + '-chance',
            anchor: '99%',
            allowBlank: false
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('slotmachine_item_active'),
            name: 'active',
            id: config.id + '-active'
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('slotmachine-item-window-update', Slotmachine.window.UpdateItem);