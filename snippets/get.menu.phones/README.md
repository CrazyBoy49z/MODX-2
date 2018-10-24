#getMenuPhones
``Пример сниппета чтобы не забыть``

Получает ресурсы с tv и отдает в шаблоны

```
[[getMenuPhones?
    &parents=`[[++menu_white_phones]]`
    &innerClass=`menu__popular_list`
    &tplOuter=`@INLINE<div class="submenu_section">[[+wrapper]]</div>`
    &tplInner=`@INLINE
        <p class="submenu_container__title">[[+section]]</p>
        <ul class="submenu [[+inner_class]]">
            [[+wrapper]]
        </ul>
    `
    &tpl=`@INLINE
        <li class="row" data-parent="[[+parent]]">
            <a href="[[+url]]" class="menu__select_model" data-document="[[+id]]">
                <span>[[+name]]</span>
            </a>
        </li>
    `
    &default=`<p class="submenu_container__description">Выберите слева модель вашего устройства и мы покажем все наши услуги</p>`
]]
```