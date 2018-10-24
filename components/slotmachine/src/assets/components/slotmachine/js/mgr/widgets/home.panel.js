Slotmachine.panel.Home = function (config) {
  config = config || {}
  Ext.apply(config, {
    baseCls: 'modx-formpanel',
    layout: 'anchor',

     stateful: true,
     stateId: 'slotmachine-panel-home',
     stateEvents: ['tabchange'],
     getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},

    hideMode: 'offsets',
    items: [
      {
        html: '<h2>' + _('slotmachine') + '</h2>',
        cls: '',
        style: {margin: '15px 0'},
      }, {
        xtype: 'modx-tabs',
        defaults: {border: false, autoHeight: true},
        border: true,
        hideMode: 'offsets',
        items: [
          {
            title: _('slotmachine_items'),
            layout: 'anchor',
            items: [
              {
                html: _('slotmachine_intro_msg'),
                cls: 'panel-desc',
              }, {
                xtype: 'slotmachine-grid-items',
                cls: 'main-wrapper',
              }],
          },
          {
            title: _('slotmachine_requests'),
            layout: 'anchor',
            items: [
              {
                html: _('slotmachine_intro_msg'),
                cls: 'panel-desc',
              }, {
                xtype: 'slotmachine-grid-requests',
                cls: 'main-wrapper',
              }],
          }],
      }],
  })
  Slotmachine.panel.Home.superclass.constructor.call(this, config)
}
Ext.extend(Slotmachine.panel.Home, MODx.Panel)
Ext.reg('slotmachine-panel-home', Slotmachine.panel.Home)
