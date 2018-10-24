Slotmachine.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'slotmachine-panel-home',
            renderTo: 'slotmachine-panel-home-div'
        }]
    });
    Slotmachine.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine.page.Home, MODx.Component);
Ext.reg('slotmachine-page-home', Slotmachine.page.Home);