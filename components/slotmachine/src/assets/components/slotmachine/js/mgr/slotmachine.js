var Slotmachine = function (config) {
    config = config || {};
    Slotmachine.superclass.constructor.call(this, config);
};
Ext.extend(Slotmachine, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('slotmachine', Slotmachine);

Slotmachine = new Slotmachine();