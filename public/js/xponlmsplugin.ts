console.log("XponLmsPlugin: xponlmsplugin.js loaded");

function confirmDialog2(message, context = null) {
    let deferred = $.Deferred();

    context = typeof (context) === 'undefined' ? null : context;

    // @ts-ignore
    return modalDialog($t("<!dialog>Confirmation"), message,
        [
            {
                // @ts-ignore
                text: $t("Yes"),
                icon: "ui-icon-check",
                class: "lms-ui-button",
                click: function () {
                    $(this).dialog("close");
                    if (context) {
                        deferred.resolveWith(context);
                    } else {
                        deferred.resolveWith(this); // bez tego w .done this == window
                    }
                }
            },
            {
                // @ts-ignore
                text: $t("No"),
                icon: "ui-icon-closethick",
                class: "lms-ui-button",
                click: function () {
                    $(this).dialog("close");
                    if (context) {
                        deferred.rejectWith(context);
                    } else {
                        deferred.rejectWith(this);
                    }
                }
            }
        ], deferred, context
    );
}

class XponLmsPlugin {
    public static readonly DEVELMODE = false;

    public static readonly URL_ONTSETUPPAGE = '?m=xpon-ontsetup';

    protected static prepareOntText(ont: OntModelInterface)
    {
        return ont.oltid + ':' +
            ont.frame + '/' +
            ont.slot + '/' +
            ont.port + '.' +
            ont.id + " \"" + ont.description + "\"";
    }

    public static ontDelete(ont: OntModelInterface) {
        let message = 'Potwierdź usuniecie ONT ' + this.prepareOntText(ont) + '<br><br>' +
            '<label><input id="related" type="checkbox" checked>Usuń obiekty powiązane (np. Service Port)</label><br>' +
            '<label><input id="customer" type="checkbox">Usuń dane klienta</label><br>';

        return confirmDialog2(message).done(function () {
            let opts = {};
            $(this).find('input[type=checkbox]').each(function () {
                opts[this.id] = $(this).is(':checked');
            });

            // @ts-ignore
            xajax_ontDelete(ont, opts);
        });
    }

    public static ontSetup(ont: OntModelInterface)
    {
        let message = 'Uruchomić konfigurację ONT ' + this.prepareOntText(ont) + '?';

        // @ts-ignore
        return confirmDialog(message).done(function () {
            XponLmsPlugin.redirectWithPostForm(XponLmsPlugin.URL_ONTSETUPPAGE, ont);
        });
    }

    public static ontRefresh(ont: OntModelInterface)
    {
        // @ts-ignore
        return xajax_ontRefresh(ont);
    }

    public static ontReboot(ont: OntModelInterface)
    {
        let message = 'Zrebootować ONT ' + this.prepareOntText(ont) + '?';

        // @ts-ignore
        return confirmDialog(message).done(function () {
            // @ts-ignore
            return xajax_ontReboot(ont);
        });
    }

    public static ontRestoreDefaults(ont: OntModelInterface)
    {
        let message = 'Przywrócić fabryczne ustawienia na ONT ' + this.prepareOntText(ont) + '?';

        // @ts-ignore
        return confirmDialog(message).done(function () {
            // @ts-ignore
            return xajax_ontRestoreDefaults(ont);
        });
    }

    public static redirectWithPostForm(url, data, mainKey = '')
    {
        let form = '<form action="' + url + '" method="post">';

        for (let name in data) {
            if (data.hasOwnProperty(name)) {
                let attrName = mainKey ? String(mainKey) + '[' + name + ']' : name;
                form += '<input type="hidden" name="' + attrName + '" value="' + data[name] + '">';
            }
        }

        form += '</form>';

        $(form).appendTo($('body')).trigger('submit');
    }

}


namespace XponLmsPlugin {
    declare function xajax_refreshOntsTab(formValues: {customerid: string, nodeid: string}): void;

    type DefaultControllerConfig = {
        containerId: string;
    }

    abstract class XponLmsPluginController<Tconfig extends DefaultControllerConfig> {
        config: Tconfig;

        container: HTMLElement;

        protected constructor(config: Tconfig) {
            this.config = config;
        }

        run() {
            document.addEventListener('DOMContentLoaded', () => {
                this.container = document.getElementById(this.config.containerId);
                if (!this.container) {
                    XponLmsPlugin.DEVELMODE && alert('No container found!');
                    throw new Error(`container '${this.config.containerId}' not found`);
                }

                this.userRun();
            });

        }

        abstract userRun(): void;
    }

    type LmsCustomerInfo = {
        id: string;
    }

    type LmsNodeInfo = {
        id: string;
    }

    interface OntsTabControllerConfig extends DefaultControllerConfig {
        ontsWasLoaded: boolean;
        customerinfo: LmsCustomerInfo;
        nodeinfo: LmsNodeInfo;
    }

    XponLmsPlugin["OntsTabController"] = class OntsTabController extends XponLmsPluginController<OntsTabControllerConfig> {

        userRun(): void {
            if (!this.config.ontsWasLoaded) {
                setTimeout(() => {
                    xajax_refreshOntsTab({
                        customerid: this.config?.customerinfo?.id,
                        nodeid: this.config?.nodeinfo?.id,
                    });
                }, 0);
            }
        }

    }

}
