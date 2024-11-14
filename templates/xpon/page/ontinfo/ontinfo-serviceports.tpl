{tab_container id="tab_container-xpon-ont-serviceportlist" label="Lista Service Port"}

    {tab_header content_id="xpon-ont-serviceportlist"}
        {tab_header_cell icon="lms-ui-icon-info"}
            <strong>Lista Service Port ({if is_array($serviceports)}{$serviceports|count}{else}0{/if})</strong>
        {/tab_header_cell}
    {/tab_header}

    {tab_contents id="xpon-ont-serviceportlist"}

        {tab_table}

            {if is_array($serviceports)}

                <div class="lms-ui-tab-table-row header">
                    <div class="lms-ui-tab-table-wrapper col-prefix-only">
                        <div class="lms-ui-tab-table-column col-default-10">
                            Id
                            <br>
                            Status / Stan administracyjny
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Vlan
                            <br>
                            User-vlan
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Cel<br>
                            Tag transform
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Ont Download
                            <br>
                            Ont Upload
                        </div>
                        <div class="lms-ui-tab-table-column col-default-10">
                            Description
                            <br>
                            Remote Description
                        </div>
                    </div>

                    <div class="lms-ui-tab-table-column control">
                        &nbsp;
                    </div>

                </div>

                {foreach $serviceports as $serviceport}
                    <div class="lms-ui-tab-table-row">
                        <div class="lms-ui-tab-table-wrapper col-prefix-only">
                            <div class="lms-ui-tab-table-column col-default-10">
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_ID]}
                                <br>
                                {if $serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_OPERSTATUS]}
                                    <span class="xpon-status-online">online</span>
                                {else}
                                    <span class="xpon-status-offline">offline</span>
                                {/if}
                                /
                                {if $serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_ADMINSTATUS]}
                                    <span class="xpon-status-online">włączony</span>
                                {else}
                                    <span class="xpon-status-offline">wyłączony</span>
                                {/if}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_VLAN]} {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_VLAN_DESCRIPTION]}
                                <br>
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_USERVLAN]}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$_type = $serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_TYPE]}
                                {if $_type == XponLmsPlugin\Model\OntServicePortModel::TYPE_GEM}
                                    GEM {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_GEM]}
                                {elseif $_type == XponLmsPlugin\Model\OntServicePortModel::TYPE_E2E}
                                    {$_target = $serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_TARGETTYPE]}
                                    {if $_target == XponLmsPlugin\Model\OntServicePortModel::TARGETTYPE_IPHOST}
                                        IPHOST
                                    {elseif $_target == XponLmsPlugin\Model\OntServicePortModel::TARGETTYPE_ONT}
                                        ONT
                                    {elseif $_target == XponLmsPlugin\Model\OntServicePortModel::TARGETTYPE_PORT}
                                        ETH {','|implode:$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_PORTS]}
                                    {/if}
                                {/if}
                                <br>
                                {$_texts = XponLmsPlugin\Model\OntServicePortModel::TAGTRANSFORM_TEXTS}
                                {$_texts[$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_TAGTRANSFORM]]|default:'?'}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_TRAFFICTABLE_OUTBOUND]}
                                <br>
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_TRAFFICTABLE_INBOUND]}
                            </div>

                            <div class="lms-ui-tab-table-column col-default-10">
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_DESCRIPTION]}
                                <br>
                                {$serviceport[XponLmsPlugin\Model\OntServicePortModel::KEY_DESCRIPTION_REMOTE]}
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
                        {if is_a($serviceports, Exception::class)}
                            Błąd: {$serviceports->getMessage()}
                        {else}
                            Nie udało się odczytać Service Port.
                        {/if}
                    </span>
                </div>
            {/if}

        {/tab_table}

    {/tab_contents}

{/tab_container}
