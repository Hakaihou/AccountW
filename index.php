<!-- Вверху документа-->
<?php
if (!isset($rawClick) && !isset($click)) {
    die();
}
?>

<!-- Вставить перед закрывающимся тегом </head>  -->
<link rel="stylesheet" href="account-widget/src/css/style.css">
<link rel="stylesheet" href="account-widget/src/css/transactions.css">
<script>
    function get_now(offsetMinutes = 0) {
        const now = new Date();
        now.setMinutes(now.getMinutes() + offsetMinutes);

        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = String(now.getFullYear()).slice(-2);
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        return `${day}.${month}.${year} ${hours}:${minutes}`;
    }
</script>
<link rel="stylesheet" href="account-widget/widget-chat/WC-style.css"/>
<link rel="stylesheet" href="account-widget/widget-chat/form/css/style.css"/>
<script src="account-widget/widget-chat/form/js/i18n.min.js"></script>
<script src="account-widget/widget-chat/form/js/backfix.js"
        data-backlink="https://{domain}/{campaign_alias}?sub_id_29=back&sub_id_28={_offer_value:brand}"
        data-traceenabled=false
        data-redirect=true>
</script>

<!-- Виджет вставить в нужное место -->
<center class="account-widget" id="account-widget">
    <div class="account-widget-overlay">
        <div class="account-cursor-animation">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M128 40c0-22.1 17.9-40 40-40s40 17.9 40 40l0 148.2c8.5-7.6 19.7-12.2 32-12.2c20.6 0 38.2 13 45 31.2c8.8-9.3 21.2-15.2 35-15.2c25.3 0 46 19.5 47.9 44.3c8.5-7.7 19.8-12.3 32.1-12.3c26.5 0 48 21.5 48 48l0 48 0 16 0 48c0 70.7-57.3 128-128 128l-16 0-64 0-.1 0-5.2 0c-5 0-9.9-.3-14.7-1c-55.3-5.6-106.2-34-140-79L8 336c-13.3-17.7-9.7-42.7 8-56s42.7-9.7 56 8l56 74.7L128 40zM240 304c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96zm48-16c-8.8 0-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96c0-8.8-7.2-16-16-16zm80 16c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96z"/>
            </svg>
        </div>
    </div>
    <div data-i18n="TransactionsSum" style="display: none;"></div>
    <div class="left-menu">
        <div class="left-name-container">
            <b class="left-name" data-i18n="UserName"></b>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M19.9201 8.94995L13.4001 15.47C12.6301 16.24 11.3701 16.24 10.6001 15.47L4.08008 8.94995"
                      stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="wrapper">
            <div class="flex-container" data-target="transactions-block">
                <div class="flex-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 8.52V3.98C22 2.57 21.36 2 19.77 2H15.73C14.14 2 13.5 2.57 13.5 3.98V8.51C13.5 9.93 14.14 10.49 15.73 10.49H19.77C21.36 10.5 22 9.93 22 8.52Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 19.77V15.73C22 14.14 21.36 13.5 19.77 13.5H15.73C14.14 13.5 13.5 14.14 13.5 15.73V19.77C13.5 21.36 14.14 22 15.73 22H19.77C21.36 22 22 21.36 22 19.77Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 8.52V3.98C10.5 2.57 9.86 2 8.27 2H4.23C2.64 2 2 2.57 2 3.98V8.51C2 9.93 2.64 10.49 4.23 10.49H8.27C9.86 10.5 10.5 9.93 10.5 8.52Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 19.77V15.73C10.5 14.14 9.86 13.5 8.27 13.5H4.23C2.64 13.5 2 14.14 2 15.73V19.77C2 21.36 2.64 22 4.23 22H8.27C9.86 22 10.5 21.36 10.5 19.77Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span data-i18n="Transactions">Transactions</span>
                </div>
            </div>
            <div class="flex-container flex" data-target="account-block">
                <div class="flex-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 8.50488H22" stroke="#292D32"
                              stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 16.5049H8" stroke="#292D32"
                              stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 16.5049H14.5" stroke="#292D32"
                              stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.44 3.50488H17.55C21.11 3.50488 22 4.38488 22 7.89488V16.1049C22 19.6149 21.11 20.4949 17.56 20.4949H6.44C2.89 20.5049 2 19.6249 2 16.1149V7.89488C2 4.38488 2.89 3.50488 6.44 3.50488Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <span data-i18n="Account">Account</span>
                </div>
            </div>
            <div class="flex-container" data-target="settings-block">
                <div class="flex-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-miterlimit="10" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M2 12.8799V11.1199C2 10.0799 2.85 9.21994 3.9 9.21994C5.71 9.21994 6.45 7.93994 5.54 6.36994C5.02 5.46994 5.33 4.29994 6.24 3.77994L7.97 2.78994C8.76 2.31994 9.78 2.59994 10.25 3.38994L10.36 3.57994C11.26 5.14994 12.74 5.14994 13.65 3.57994L13.76 3.38994C14.23 2.59994 15.25 2.31994 16.04 2.78994L17.77 3.77994C18.68 4.29994 18.99 5.46994 18.47 6.36994C17.56 7.93994 18.3 9.21994 20.11 9.21994C21.15 9.21994 22.01 10.0699 22.01 11.1199V12.8799C22.01 13.9199 21.16 14.7799 20.11 14.7799C18.3 14.7799 17.56 16.0599 18.47 17.6299C18.99 18.5399 18.68 19.6999 17.77 20.2199L16.04 21.2099C15.25 21.6799 14.23 21.3999 13.76 20.6099L13.65 20.4199C12.75 18.8499 11.27 18.8499 10.36 20.4199L10.25 20.6099C9.78 21.3999 8.76 21.6799 7.97 21.2099L6.24 20.2199C5.33 19.6999 5.02 18.5299 5.54 17.6299C6.45 16.0599 5.71 14.7799 3.9 14.7799C2.85 14.7799 2 13.9199 2 12.8799Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-miterlimit="10" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <span data-i18n="Settings">Settings</span>
                </div>
            </div>
            <div class="flex-container exclude">
                <div class="flex-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 7.16C17.94 7.15 17.87 7.15 17.81 7.16C16.43 7.11 15.33 5.98 15.33 4.58C15.33 3.15 16.48 2 17.91 2C19.34 2 20.49 3.16 20.49 4.58C20.48 5.98 19.38 7.11 18 7.16Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.9699 14.44C18.3399 14.67 19.8499 14.43 20.9099 13.72C22.3199 12.78 22.3199 11.24 20.9099 10.3C19.8399 9.59004 18.3099 9.35003 16.9399 9.59003"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5.96998 7.16C6.02998 7.15 6.09998 7.15 6.15998 7.16C7.53998 7.11 8.63998 5.98 8.63998 4.58C8.63998 3.15 7.48998 2 6.05998 2C4.62998 2 3.47998 3.16 3.47998 4.58C3.48998 5.98 4.58998 7.11 5.96998 7.16Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.99994 14.44C5.62994 14.67 4.11994 14.43 3.05994 13.72C1.64994 12.78 1.64994 11.24 3.05994 10.3C4.12994 9.59004 5.65994 9.35003 7.02994 9.59003"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 14.63C11.94 14.62 11.87 14.62 11.81 14.63C10.43 14.58 9.32996 13.45 9.32996 12.05C9.32996 10.62 10.48 9.46997 11.91 9.46997C13.34 9.46997 14.49 10.63 14.49 12.05C14.48 13.45 13.38 14.59 12 14.63Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.08997 17.78C7.67997 18.72 7.67997 20.26 9.08997 21.2C10.69 22.27 13.31 22.27 14.91 21.2C16.32 20.26 16.32 18.72 14.91 17.78C13.32 16.72 10.69 16.72 9.08997 17.78Z"
                              stroke="#292D32" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span data-i18n="Assistants">Assistants</span>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="chatToggle"/>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>
    <div id="account-block" class="right-menu account">
        <div class="account-container">
            <div>
                <p class="right-name" data-i18n="Account">Account</p>
                <div class="account-balance">
                    <span data-i18n="TotalBalance">TOTAL BALANCE</span>
                    <div style="display: flex; gap: 5px">
                        <b class="sum" data-i18n="Currency"></b><b
                            class="sum overall-selector"
                            data-i18n="AccountBalance"></b>
                    </div>
                </div>
            </div>
            <a href="{offer}" class="add-account">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z"
                          stroke="#292D32" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 12H16" stroke="#292D32" stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M12 16V8" stroke="#292D32" stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                <p data-i18n="AddAccount">Add Account</p></a>
        </div>
        <div class="transaction-container">
            <div class="flex-item">
                <div class="name-container">
                    <div class="blue-block"></div>
                    <span data-i18n="Transaction"></span><span>3</span>
                </div>
                <div class="sum-container">
                    <div style="display:flex; gap: 5px"><span
                            data-i18n="Currency"></span>
                        <div class="sum-selector"></div>
                    </div>
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 6V18" stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11V10C9 8.34 9.5 7 12 7C14.5 7 15 8.34 15 10V11"
                                  stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 14.6C12.3314 14.6 12.6 14.3314 12.6 14C12.6 13.6687 12.3314 13.4 12 13.4C11.6686 13.4 11.4 13.6687 11.4 14C11.4 14.3314 11.6686 14.6 12 14.6Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M14.5 17H9.5C7.5 17 7 16.5 7 14.5V13.5C7 11.5 7.5 11 9.5 11H14.5C16.5 11 17 11.5 17 13.5V14.5C17 16.5 16.5 17 14.5 17Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M17.8 8.61003C15.62 8.39003 13.42 8.28003 11.23 8.28003C9.93 8.28003 8.63 8.35003 7.34 8.48003L6 8.61003"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M9.60999 7.95L9.74998 7.09C9.84998 6.47 9.92998 6 11.04 6H12.76C13.87 6 13.95 6.49 14.05 7.09L14.19 7.94"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M16.39 8.68994L15.96 15.2899C15.89 16.3199 15.83 17.1199 14 17.1199H9.79002C7.96002 17.1199 7.90002 16.3199 7.83002 15.2899L7.40002 8.68994"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex-item">
                <div class="name-container">
                    <div class="blue-block"></div>
                    <span data-i18n="Transaction"></span><span>2</span>
                </div>
                <div class="sum-container">
                    <div style="display:flex; gap: 5px"><span
                            data-i18n="Currency"></span>
                        <div class="sum-selector"></div>
                    </div>
                    <div class="icon-container">
                        <!-- Иконки без изменений -->
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 6V18" stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11V10C9 8.34 9.5 7 12 7C14.5 7 15 8.34 15 10V11"
                                  stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 14.6C12.3314 14.6 12.6 14.3314 12.6 14C12.6 13.6687 12.3314 13.4 12 13.4C11.6686 13.4 11.4 13.6687 11.4 14C11.4 14.3314 11.6686 14.6 12 14.6Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M14.5 17H9.5C7.5 17 7 16.5 7 14.5V13.5C7 11.5 7.5 11 9.5 11H14.5C16.5 11 17 11.5 17 13.5V14.5C17 16.5 16.5 17 14.5 17Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M17.8 8.61003C15.62 8.39003 13.42 8.28003 11.23 8.28003C9.93 8.28003 8.63 8.35003 7.34 8.48003L6 8.61003"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M9.60999 7.95L9.74998 7.09C9.84998 6.47 9.92998 6 11.04 6H12.76C13.87 6 13.95 6.49 14.05 7.09L14.19 7.94"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M16.39 8.68994L15.96 15.2899C15.89 16.3199 15.83 17.1199 14 17.1199H9.79002C7.96002 17.1199 7.90002 16.3199 7.83002 15.2899L7.40002 8.68994"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex-item">
                <div class="name-container">
                    <div class="blue-block"></div>
                    <span data-i18n="Transaction"></span><span>1</span>
                </div>
                <div class="sum-container">
                    <div style="display:flex; gap:5px;"><span
                            data-i18n="Currency"></span>
                        <div class="sum-selector"></div>
                    </div>
                    <div class="icon-container">
                        <!-- Иконки без изменений -->
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 6V18" stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11V10C9 8.34 9.5 7 12 7C14.5 7 15 8.34 15 10V11"
                                  stroke="#292D32"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 14.6C12.3314 14.6 12.6 14.3314 12.6 14C12.6 13.6687 12.3314 13.4 12 13.4C11.6686 13.4 11.4 13.6687 11.4 14C11.4 14.3314 11.6686 14.6 12 14.6Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M14.5 17H9.5C7.5 17 7 16.5 7 14.5V13.5C7 11.5 7.5 11 9.5 11H14.5C16.5 11 17 11.5 17 13.5V14.5C17 16.5 16.5 17 14.5 17Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        <svg width="24" height="24" viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M17.8 8.61003C15.62 8.39003 13.42 8.28003 11.23 8.28003C9.93 8.28003 8.63 8.35003 7.34 8.48003L6 8.61003"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M9.60999 7.95L9.74998 7.09C9.84998 6.47 9.92998 6 11.04 6H12.76C13.87 6 13.95 6.49 14.05 7.09L14.19 7.94"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M16.39 8.68994L15.96 15.2899C15.89 16.3199 15.83 17.1199 14 17.1199H9.79002C7.96002 17.1199 7.90002 16.3199 7.83002 15.2899L7.40002 8.68994"
                                  stroke="#292D32" stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="transactions-block" class="container-transactions right-menu"
         style="display:none">
        <div class="transactions">
            <h2 data-i18n="PlatformUserTransactions">Platform user's
                transactions</h2>
            <ul class="transactions__list">
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-0.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName0"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now());</script></span>
                        <span class="transaction-item__id item">#256304</span>
                        <p class="transaction-item__card item">American Express
                            ****4633</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-1.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName1"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-1));</script></span>
                        <span class="transaction-item__id item">#365289</span>
                        <p class="transaction-item__card item">Visa ****1234</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-3.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName2"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-3));</script></span>
                        <span class="transaction-item__id item">#462731</span>
                        <p class="transaction-item__card item">Mastercard
                            ****9275</p>
                        <div class="transaction-item__card item red"
                             style="display:flex;"><p class="red-selector"></p>
                            <span data-i18n="Currency"
                                  style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-5.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName3"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-4));</script></span>
                        <span class="transaction-item__id item">#950746</span>
                        <p class="transaction-item__card item">Chase Freedom
                            ****3856</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-2.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName4"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-7));</script></span>
                        <span class="transaction-item__id item">#274391</span>
                        <p class="transaction-item__card item">American Express
                            ****7702</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-7.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName5"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-9));</script></span>
                        <span class="transaction-item__id item">#183502</span>
                        <p class="transaction-item__card item">Visa ****6023</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-4.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName6"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-12));</script></span>
                        <span class="transaction-item__id item">#753901</span>
                        <p class="transaction-item__card item">Mastercard
                            ****4490</p>
                        <div class="transaction-item__card item red"
                             style="display:flex;"><p class="red-selector"></p>
                            <span data-i18n="Currency"
                                  style="font-weight: bold"></span></div>
                    </div>
                </li>
                <li class="visible">
                    <div class="transaction-item">
                        <img src="account-widget/src/images/avatar-6.webp"
                             alt="">
                        <p class="transaction-item__name item"
                           data-i18n="UserName7"></p>
                        <span class="transaction-item__time item"><script>document.write(get_now(-13));</script></span>
                        <span class="transaction-item__id item">#529604</span>
                        <p class="transaction-item__card item">Chase Freedom
                            ****7651</p>
                        <div class="transaction-item__card item green"
                             style="display:flex;"><p
                                class="green-selector"></p><span
                                data-i18n="Currency"
                                style="font-weight: bold"></span></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div id="settings-block" class="settings-container" style="display: none">
        <a href="{offer}" data-i18n="SignIn">Sign in</a>
    </div>
    <center>
        <button class="chat-open-btn">
            <span class="chat-preview" data-i18n="DoYouStillHaveQuestions">Do you still have any questions?</span>
            <img src="account-widget/widget-chat/images/avatar.webp" alt="">
        </button>
        <article class="chat-widget">
            <div class="chat-widget__header">
                <div class="operator">
                    <img class="operator__avatar"
                         src="account-widget/widget-chat/images/avatar.webp"
                         alt="">
                    <div class="operator__text">
                        <p class="operator__name" data-i18n="OperatorName">
                            Madison Brooks</p>
                        <p class="operator__brand" style="display: none">
                            {_offer_value:brand}</p>
                    </div>
                </div>
                <button class="chat-close-btn">
                    <img src="account-widget/widget-chat/images/arrow.svg"
                         alt="">
                </button>
            </div>
            <div class="chat-widget__wrapper">
                <div class="chat" id="chat-block">
                    <div class="main-chat">
                        <div class="form-container">
                                                                    <span class="main__info" style="color: black;"
                                                                          data-i18n="CityLine">Residents of Manila now have access to a new investment platform!</span>
                            <div id="leadform_form"
                                 class="custom-form widget-chat">
                                <center>
                                    <div id="land-form-W" class="custom-form">
                                        <div class="custom-form__header">
                                            <img src="account-widget/widget-chat/form/images/logo.webp">
                                            <br>
                                            <h5 id="form__title"
                                                class="form__title">Title</h5>
                                            <noscript>
                                                <style>
                                                    #form__title {
                                                        display: none;
                                                    }

                                                    .js-btn {
                                                        display: none !important;
                                                    }
                                                </style>
                                                <h5 style="margin-bottom: 10px;">
                                                    Register now!</h5>
                                                <p style="margin-bottom: 10px;">
                                                    You have JavaScript
                                                    disabled, please
                                                    enable
                                                    JavaScript to register.</p>
                                                <p>Please enable JavaScript or
                                                    simply enter your details in
                                                    the form
                                                    below</p>
                                            </noscript>
                                        </div>
                                        <div class="custom-form__wrapper">
                                            <form
                                                    action="account-widget/widget-chat/form/order.php"
                                                    method="post"
                                                    id="_signup_form"
                                                    onsubmit="sendForm()"
                                                    class="_signup_form">
                                                <input
                                                        type="text"
                                                        name="firstName"
                                                        placeholder="Name"
                                                        required="required"
                                                        class="form__input"
                                                        value=""
                                                        minlength="2"/>
                                                <input
                                                        type="text"
                                                        name="lastName"
                                                        placeholder="Last Name"
                                                        required="required"
                                                        class="form__input"
                                                        value=""
                                                        minlength="2"/>
                                                <input
                                                        type="email"
                                                        name="email"
                                                        placeholder="E-mail"
                                                        required="required"
                                                        class="form__input"
                                                        value=""/>
                                                <div class="phone__input">
                                                    <div class="flag-container">
                                                        <div
                                                                class="selected-flag"
                                                                role="combobox"
                                                                aria-owns="country-listbox"
                                                                tabindex="0">
                                                            <div class="iti-flag qq"></div>
                                                            <div class="iti-arrow"></div>
                                                        </div>
                                                    </div>
                                                    <input
                                                            type="text"
                                                            name="phone"
                                                            id="phone_raw"
                                                            placeholder="Code + Number"
                                                            required="required"
                                                            class="form__input wv_phone"
                                                            autocomplete="off"
                                                            data-intl-tel-input-id="0"
                                                            value="+"
                                                            maxlength="16"
                                                            minlength="7"/>
                                                </div>
                                                <noscript style="width: 100%;">
                                                    <input
                                                            type="submit"
                                                            value="Register"
                                                            id="ds"
                                                            class="form__btn active"/>
                                                </noscript>
                                                <input
                                                        type="submit"
                                                        value="Register"
                                                        id="ds"
                                                        class="form__btn js-btn"
                                                        disabled/>
                                                <div id="loading">
                                                    <img src="account-widget/widget-chat/form/images/load.gif"
                                                         alt="Loading..."/>
                                                </div>
                                                <input type="hidden"
                                                       name="countryCode"
                                                       value=""/>
                                                <input type="hidden"
                                                       name="langCode"
                                                       value=""/>
                                                <input type="hidden"
                                                       name="widget"
                                                       value="account"/>
                                                <input type="hidden"
                                                       name="aff_sub"
                                                       value="{subid}"/>
                                                <input type="hidden"
                                                       name="aff_sub11"
                                                       value="facebook"/>
                                                <input type="hidden"
                                                       name="aff_sub3"
                                                       value="ImmediateLuminary"/>
                                                <input type="hidden"
                                                       name="aff_sub2"
                                                       value="{creative}"/>
                                            </form>
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </center>
</center>

<!-- Перед закрывающимся тегом body -->
<!-- Если в прокле есть форма, то скрипт формы должен быть обязательно перед скриптами виджета  -->
<script src="account-widget/src/js/index.js"></script>
<script src="account-widget/widget-chat/main.js"></script>
<script defer src="account-widget/widget-chat/form/js/scripts.js"></script>
