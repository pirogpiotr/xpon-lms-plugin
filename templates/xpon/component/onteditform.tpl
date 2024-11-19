{$columnsTotal = 2}

<form id="xpon-onteditform" name="ont" autocomplete="off">
    <table id="xpon-onteditform-table" class="lmsbox">
        <thead>
            <tr>
                <td>
                    <span class="xpon-label">Numer seryjny</span>
                </td>
                <td>
                    {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_SN])}
                        <input name="ont[{XponLmsPlugin\Model\OntModel::KEY_SN}]" type="hidden"
                               value="{$ont[XponLmsPlugin\Model\OntModel::KEY_SN]}">
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_SN]}
                    {else}
                        <input name="ont[{XponLmsPlugin\Model\OntModel::KEY_SN}]"
                               type="text" maxlength="16" size="16">
                    {/if}
                </td>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td>
                    <span class="xpon-label">OLT</span>
                </td>
                <td>
                    {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID])}
                        <input type="hidden" name="ont[{XponLmsPlugin\Model\OntModel::KEY_OLT_ID}]"
                               value="{$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]}">
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_ID]} {$ont[XponLmsPlugin\Model\OntModel::KEY_OLT_NAME]|default:''}
                    {else}
                        <select id="olt-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_OLT_ID}]">
                            {if count($olts) > 1}
                                <option value="" style="display: none;">- wybierz OLT -</option>
                            {/if}
                            {foreach $olts as $olt}
                                <option value="{$olt[XponLmsPlugin\Model\OltModel::KEY_ID]}"
                                        {if count($olts) < 2}selected{/if}>
                                    ({$olt[XponLmsPlugin\Model\OltModel::KEY_ID]})
                                    {$olt[XponLmsPlugin\Model\OltModel::KEY_NAME]}
                                </option>
                            {/foreach}
                        </select>
                    {/if}
                </td>
            </tr>

            {$isset = isset($ont[XponLmsPlugin\Model\OntModel::KEY_IFINDEX])}

            <tr>
                <td>
                    <span class="xpon-label">Slot{if $isset}/Port{/if}</span>
                </td>
                <td>
                    {if $isset}
                        {$fsp = XponLmsPlugin\Lib\Helper::decodeHuaweiIfIndex($ont[XponLmsPlugin\Model\OntModel::KEY_IFINDEX])}
                        {$fsp.0}/{$fsp.1}/{$fsp.2} {$ont[XponLmsPlugin\Model\OntModel::KEY_PORT_DESCRIPTION]|default:''}
                        <input type="hidden" name="ont[{XponLmsPlugin\Model\OntModel::KEY_IFINDEX}]" value="{$ont[XponLmsPlugin\Model\OntModel::KEY_IFINDEX]}">
                    {else}
                        <select id="slot-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_SLOT}]">
                            {${XponLmsPlugin\Controller\Page\OntAddPageController::KEY_CONTENT_SLOTS}|default:''}
                        </select>
                    {/if}
                </td>
            </tr>

            {if !$isset}
                <tr>
                    <td>
                        <span class="xpon-label">Port</span>
                    </td>
                    <td>
                        <select id="port-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_PORT}]">
                            {${XponLmsPlugin\Controller\Page\OntAddPageController::KEY_CONTENT_PORTS}|default:''}
                        </select>
                    </td>
                </tr>
            {/if}

            {if isset($ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION])}
                <tr>
                    <td>
                        <span class="xpon-label">Ont id</span>
                    </td>
                    <td>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_ID]}
                        <input type="hidden" name="ont[{XponLmsPlugin\Model\OntModel::KEY_ID}]" value="{$ont[XponLmsPlugin\Model\OntModel::KEY_ID]}">
                    </td>
                </tr>
            {/if}

            {if array_key_exists(XponLmsPlugin\Model\OntModel::KEY_EQUIPID, $ont)}
                <tr>
                    <td>
                        <span class="xpon-label">Model</span>
                    </td>
                    <td>
                        {$ont[XponLmsPlugin\Model\OntModel::KEY_EQUIPID]|default:'-'}
                    </td>
                </tr>
            {/if}

            <tr>
                <td colspan="{$columnsTotal}">&nbsp;</td>
            </tr>

            <tr>
                <td>
                    <span class="xpon-label">Opis</span>
                </td>
                <td>
                    <input id="input-description" type="text" name="ont[{XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION}]"
                           value="{$ont[XponLmsPlugin\Model\OntModel::KEY_DESCRIPTION]|default:''|escape}">
                </td>
            </tr>

            {if array_key_exists(XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE, $ont)}
                {$configmode = $ont[XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE]|default:XponLmsPlugin\Model\OntModel::CONFIGMODE_MANUAL}
            {else}
                {$configmode = XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE}
            {/if}
            <tr>
                <td>
                    <span class="xpon-label">Tryb konfiguracji</span>
                </td>
                <td>
                    <select id="configmode-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_CONFIGMODE}]">
                        {$arr = [XponLmsPlugin\Model\OntModel::CONFIGMODE_MANUAL => "Ręczny", XponLmsPlugin\Model\OntModel::CONFIGMODE_AUTO => "Automatyczny", XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE => "Profil"]}
                        {foreach $arr as $key => $description}
                            <option value="{$key}" {if $configmode == $key}selected{/if}>{$description}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>

            <tr id="row-setupprofile" {if $configmode != XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE}
                style="display: none;"{/if}>
                <td>
                    <span class="xpon-label">Profil</span>
                </td>
                <td>
                    {$val = $ont[XponLmsPlugin\Model\OntModel::KEY_SETUPPROFILE]|default:''}
                    <select id="setupprofile-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_SETUPPROFILE}]">
                        {if $val == ""}
                            <option value="" style="display: none;">- wybierz profil -</option>
                        {/if}
                        {foreach $setupprofiles as $profile}
                            {$name = $profile[XponLmsPlugin\Model\OntSetupProfileModel::KEY_NAME]}
                            <option value="{$name}" {if $val == $name}selected{/if}>{$name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="{$columnsTotal}">&nbsp;</td>
            </tr>

            <tr>
                <td>
                    <span class="xpon-label">Klient</span>
                </td>
                <td>
                    <input type="hidden" id="customerid"
                           name="ont[{XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID}]"
                           value="{$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID]|default:null}">
                    {customerlist
                        form = "ont"
                        customers = $customers
                        selected = {$ont[XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID]|default:null}
                        selectname = "temp[{XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID}2]"
                        select_id = "customer-select"
                        inputname = "temp[{XponLmsPlugin\Model\OntModel::KEY_CUSTOMER_ID}]"
                        input_id = "customer-select-text"
                        selecttip = "Wybierz klienta"
                        required = false
                    }
                </td>
            </tr>

            <tr>
                <td>
                    <span class="xpon-label">Komputer</span>
                </td>
                <td>
                    <select id="node-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_NODE_ID}]">
                        {${XponLmsPlugin\Controller\Page\OntAddPageController::KEY_CONTENT_NODES}|default:''}
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="xpon-label">Konto voip 1</span>
                </td>
                <td>
                    <select id="voip-1-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_1}]">
                        {${XponLmsPlugin\Controller\Page\OntAddPageController::KEY_CONTENT_VOIP}.1|default:''}
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="xpon-label">Konto voip 2</span>
                </td>
                <td>
                    <select id="voip-2-select" name="ont[{XponLmsPlugin\Model\OntModel::KEY_VOIP_ACCOUNT_2}]">
                        {${XponLmsPlugin\Controller\Page\OntAddPageController::KEY_CONTENT_VOIP}.2|default:''}
                    </select>
                </td>
            </tr>

            {foreach $ont[XponLmsPlugin\Model\OntModel::KEY_SERVICES] as $service}
                <input type="hidden" name="ont[{XponLmsPlugin\Model\OntModel::KEY_SERVICES}][]" value="{$service}">
            {/foreach}

            <tr>
                <td>
                    <span class="xpon-label">IPTV</span>
                </td>
                <td>
                    <label>
                        <input type="checkbox" name="service_iptv" value="1" {if in_array(XponLmsPlugin\Model\OntModel::SERVICE_IPTV, $ont[XponLmsPlugin\Model\OntModel::KEY_SERVICES]|default:[])}checked{/if}> Włącz IPTV
                    </label>
                </td>
            </tr>

            <tr>
                <td>
                </td>
                <td>
                    {foreach [1, 2, 3, 4] as $portId}
                        <label>
                            <input type="checkbox" name="service_iptv_ports[]" value="{$portId}" {if in_array($portId, $ont[XponLmsPlugin\Model\OntModel::KEY_IPTV_PORTS]|default:[])}checked{/if}> Port {$portId}
                        </label>
                    {/foreach}
                </td>
            </tr>

            <tr>
                <td colspan="{$columnsTotal}">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="{$columnsTotal}">
                    <table id="attributes">
                        <thead>
                            <tr>
                                <td class="xpon-label">Nazwa</td>
                                <td class="xpon-label">Wartość</td>
                                <td class="xpon-label">Opis</td>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $attributes as $attribute}
                                <tr>
                                    <td class="xpon-label">
                                        {$attribute[XponLmsPlugin\Model\OntAttributeModel::KEY_NAME]}
                                    </td>
                                    <td>
                                        <input type="text" name="ont[attributes][{$attribute[XponLmsPlugin\Model\OntAttributeModel::KEY_NAME]}]" value="{$attribute[XponLmsPlugin\Model\OntAttributeModel::KEY_VALUE]|default:''|escape}" >
                                    </td>
                                    <td>
                                        {$attribute[XponLmsPlugin\Model\OntAttributeModel::KEY_DESCRIPTION]|default:''}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="{$columnsTotal}">&nbsp;</td>
            </tr>

            {if $buttons}
                <tr>
                    <td class="lms-ui-box-buttons" colspan="{$columnsTotal}">
                        {$buttons}
                    </td>
                </tr>
            {/if}

        </tbody>

    </table>
</form>

<script id="xpon-onteditform-js" type="text/javascript" language="javascript">
    $(function () {
        let jqForm = $('#xpon-onteditform');

        function redrawSlotPort()
        {
            let oltId = jqForm.find('#olt-select').val();
            let slotId = jqForm.find('#slot-select').val();
            xajax_redrawSlotPort(oltId, slotId);
        }

        jqForm.find('#customer-select, #customer-select-text').on('change', function (event) {
            let customerId = $(event.target).val();

            if (customerId < 1) {
                customerId = null;
            }

            jqForm.find('#customerid').val(customerId);
            xajax_redrawCustomerAccounts(customerId);
        });

        jqForm.find('#olt-select, #slot-select').on('change', function () {
            redrawSlotPort();
        });

        jqForm.find('#configmode-select').on('change', function (event) {
            let mode = parseInt($(event.target).val());
            $('#row-setupprofile').toggle(mode === {XponLmsPlugin\Model\OntModel::CONFIGMODE_PROFILE});
        });
    });
</script>
