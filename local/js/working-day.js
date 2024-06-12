let Working = BX.namespace('Working');

Working.registerTimemanEvent = function() {
    BX.addCustomEvent('onPlannerDataRecieved', Working.modifyStartButton);
    BX.addCustomEvent('onTimeManWindowBuild', Working.addConfirmationText);
};

Working.modifyStartButton = function () {
    let createPopup = function (btn) {
        let continueOptions = {
            text: 'Подтвердить',
            id: 'continue-btn',
            className: 'ui-btn ui-btn-success',
            events: {
                click: function() {
                    popup.close();
                    popup.destroy();
                    btn.click();
                }
            }
        };
        let buttonContinue = new BX.PopupWindowButton(continueOptions);

        let popup = BX.PopupWindowManager.create('popup-working', null, {
            content: 'Подтвердите начало/продолжение рабочего дня',
            width: 300,
            height: 250,
            zIndex: 100,
            closeIcon: { opacity: 1 },
            titleBar: 'Подтвеждение',
            closeByEsc: true,
            autoHide: true,
            overlay: { backgroundColor: '#000000', opacity: 50 },
            buttons: [buttonContinue]
        });

        popup.show();
    };

    let searchOptions = {tag: 'button', className: 'ui-btn ui-btn-success ui-btn-icon-start'};
    let allButtons = BX.findChildren(BX('timeman_main'), searchOptions, true);

    if (allButtons.length == 1) {
        let startButton = allButtons[0];
        let txt = startButton.textContent;
        let elem = BX.create('button', {
            props: {
                className: 'ui-btn ui-btn-success ui-btn-icon-start'
            },
            events: {
                click: function() {
                    createPopup(startButton);
                }
            },
            text: txt
        });
        BX.insertAfter(elem, startButton);
        BX.style(startButton, 'display', 'none');
    }
};

Working.addConfirmationText = function () {
    let searchOptions = {tag: 'div', className: 'tm-popup-notice'};
    let noticeBlock = BX.findChild(BX('timeman_main'), searchOptions, true);
    if (noticeBlock) {
        let elem = BX.create('div', {
            props: {
                className: 'ui-alert ui-alert-danger ui-alert-xs ui-alert-icon-danger working-mt10'
            },
            html: '<span class="ui-alert-message"><strong>Подтвердите изменение статуса рабочего дня</strong></span>'
        });
        BX.insertAfter(elem, noticeBlock);
    }
};