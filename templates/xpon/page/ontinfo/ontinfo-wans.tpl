{tab_container id="tab_container-xpon-ont-wanlist" label="Lista WAN"}

    {tab_header content_id="xpon-ont-wanlist"}
        {tab_header_cell icon="lms-ui-icon-info"}
            <strong>Lista WAN ({if is_array($wans)}{$wans|count}{else}0{/if})</strong>
        {/tab_header_cell}
    {/tab_header}

    {tab_contents id="xpon-ont-wanlist"}

        {tab_table}
            {if is_array($wans)}

                <div class="lms-ui-tab-table-row header">
                    <div class="lms-ui-tab-table-wrapper col-prefix-only">
                        <div class="lms-ui-tab-table-column col-default-10">
                            Id<br>Opis
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Usługa<br>Tryb / Typ adresu
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Status<br>
                            Stan administracyjny
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            IP<br>
                            Maska
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Brama<br>
                            Vlan
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Mac address<br>
                            Multicast vlan
                        </div>
                    </div>
                    <div class="lms-ui-tab-table-column control">
                        &nbsp;
                    </div>
                </div>

                {foreach $wans as $wan}
                    <div class="lms-ui-tab-table-row">
                        <div class="lms-ui-tab-table-wrapper col-prefix-only">
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_ID]}
                                <br>
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_DESCRIPTION]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$_texts = XponLmsPlugin\Model\OntWanModel::SERVICETYPE_TEXTS}
                                {$_texts[$wan[XponLmsPlugin\Model\OntWanModel::KEY_SERVICETYPE]]}
                                <br>
                                {$_texts = XponLmsPlugin\Model\OntWanModel::LAYER_TEXTS}
                                {$_texts[$wan[XponLmsPlugin\Model\OntWanModel::KEY_LAYER]]}
                                /
                                {$_texts = XponLmsPlugin\Model\OntWanModel::IPTYPE_TEXTS}
                                {$_texts[$wan[XponLmsPlugin\Model\OntWanModel::KEY_IPTYPE]]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$_val = $wan[XponLmsPlugin\Model\OntWanModel::KEY_STATE]}
                                {$_texts = XponLmsPlugin\Model\OntWanModel::STATE_TEXTS}
                                {if $_val == XponLmsPlugin\Model\OntWanModel::STATE_CONNECTED}
                                    {$_class = "xpon-status-online"}
                                {else}
                                    {$_class = "xpon-status-offline"}
                                {/if}
                                <span class="{$_class}">
                                    {$_texts[$_val]}
                                </span>
                                <br>
                                {if !isset($wan[XponLmsPlugin\Model\OntWanModel::KEY_ENABLED])}
                                    -
                                {elseif $wan[XponLmsPlugin\Model\OntWanModel::KEY_ENABLED]}
                                    <span class="xpon-status-online">włączony</span>
                                {else}
                                    <span class="xpon-status-offline">wyłączony</span>
                                {/if}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_IPADDR]}
                                <br>
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_MASK]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_GATEWAY]}
                                <br>
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_VLANID]} p{$wan[XponLmsPlugin\Model\OntWanModel::KEY_VLANP]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                <span id="wan-mac-{$wan[XponLmsPlugin\Model\OntWanModel::KEY_ID]}">{$wan[XponLmsPlugin\Model\OntWanModel::KEY_MAC]}</span>
                                <br>
                                {$wan[XponLmsPlugin\Model\OntWanModel::KEY_MVLANID]|default:'-'}
                            </div>
                        </div>

                        <div class="lms-ui-tab-table-column control">
                            &nbsp;
                        </div>
                    </div>
                {foreachelse}
                    <div class="lms-ui-tab-empty-table">
                            Nie znaleziono WAN.
                    </div>
                {/foreach}

            {else}
                <div class="lms-ui-tab-empty-table">
                    <span class="xpon-error">
                        {if is_a($wans, Exception::class)}
                            Błąd: {$wans->getMessage()}
                        {else}
                            Nie udało się odczytać WAN.
                        {/if}
                    </span>
                </div>

            {/if}


        {/tab_table}

    {/tab_contents}

{/tab_container}
