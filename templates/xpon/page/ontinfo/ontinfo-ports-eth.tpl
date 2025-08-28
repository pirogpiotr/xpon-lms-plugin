{tab_container id="tab_container-xpon-ont-ethlist" label="Stan portów ETH"}

    {tab_header content_id="xpon-ont-ethlist"}
        {tab_header_cell icon="lms-ui-icon-info"}
            <strong>Lista portów ETH ({if is_array($eths)}{$eths|count}{else}0{/if})</strong>
        {/tab_header_cell}
    {/tab_header}

    {tab_contents id="xpon-ont-ethlist"}

        {tab_table}

            {if is_array($eths)}

                <div class="lms-ui-tab-table-row header">
                    <div class="lms-ui-tab-table-wrapper col-prefix-only">
                        <div class="lms-ui-tab-table-column col-default-10">
                            Port
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Typ
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Stan administracyjny
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Status
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Autonegocjacja
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Prędkość
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Duplex
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Natywny vlan
                        </div>
                    </div>

                    <div class="lms-ui-tab-table-column control">
                        &nbsp;
                    </div>

                </div>

                {foreach $eths as $eth}
                    <div class="lms-ui-tab-table-row">
                        <div class="lms-ui-tab-table-wrapper col-prefix-only">
                            <div class="lms-ui-tab-table-column col-default-10">
                                ETH {$eth[XponLmsPlugin\Model\OntPortEthModel::KEY_ID]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$eth[XponLmsPlugin\Model\OntPortEthModel::KEY_PORTTYPE]}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {if $eth[XponLmsPlugin\Model\OntPortEthModel::KEY_ENABLED]}
                                    <span class="xpon-status-online">włączony</span>
                                {else}
                                    <span class="xpon-status-offline">wyłączony</span>
                                {/if}
                            </div>
                            <div class="lms-ui-tab-table-column col-default-10">
                                {if $eth[XponLmsPlugin\Model\OntPortEthModel::KEY_STATUS]}
                                    <span class="xpon-status-online">online</span>
                                {else}
                                    <span class="xpon-status-offline">offline</span>
                                {/if}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {if $eth[XponLmsPlugin\Model\OntPortEthModel::KEY_AUTONEGOTIATION]}
                                    tak
                                {else}
                                    nie
                                {/if}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$eth[XponLmsPlugin\Model\OntPortEthModel::KEY_SPEED]|default:'?'}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$_texts = XponLmsPlugin\Model\OntPortEthModel::DUPLEX_TEXTS}
                                {$_texts[$eth[XponLmsPlugin\Model\OntPortEthModel::KEY_DUPLEX]]|default:'?'}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$eth[XponLmsPlugin\Model\OntPortEthModel::KEY_VLAN_ID]}
                                {if $_val = $eth[XponLmsPlugin\Model\OntPortEthModel::KEY_VLAN_PRIORITY]}
                                    p{$_val}
                                {/if}
                            </div>
                        </div>

                        <div class="lms-ui-tab-table-column control">
                            &nbsp;
                        </div>

                    </div>

                {/foreach}

            {else}
                <div class="lms-ui-tab-empty-table">
                    <span class="xpon-error">
                        {if is_a($eths, Exception::class)}
                            Błąd: {$eths->getMessage()}
                        {else}
                            Nie udało się odczytać stanu portów ETH.
                        {/if}
                    </span>
                </div>
            {/if}

        {/tab_table}

    {/tab_contents}

{/tab_container}
