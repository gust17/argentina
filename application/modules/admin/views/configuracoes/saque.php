<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Editar Configurações de Saque</h4>
                <p class="card-title-desc">Edite as regras de saque do sistema.</p>

                <div class="mt-4">
                    <?php if (isset($message)) echo $message; ?>
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Geral</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Rendimentos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Rede</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#raiz" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Raiz</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <form action="" method="post">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Saques Habilitados</td>
                                                        <td>
                                                            <input type="radio" name="saque_liberado" value="1" <?php echo ($saque_liberado == 1) ? 'checked' : ''; ?>> Sim <br />
                                                            <input type="radio" name="saque_liberado" value="0" <?php echo ($saque_liberado == 0) ? 'checked' : ''; ?>> Não
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Regra de Saque</td>
                                                        <td>
                                                            <input type="radio" name="apos_vencido" value="1" <?php echo ($regra_saque == 1) ? 'checked' : ''; ?>> Sacar somente após vencer o plano <br />
                                                            <input type="radio" name="apos_vencido" value="0" <?php echo ($regra_saque == 0) ? 'checked' : ''; ?>> Sacar a qualquer momento
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Prazo de pagamento (em dias úteis)</td>
                                                        <td>
                                                            <input type="number" name="prazo_saque" class="form-control" value="<?php echo $dias_uteis; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Prazo de pagamento de urgência (em horas)</td>
                                                        <td>
                                                            <input type="number" name="prazo_urgencia" class="form-control" value="<?php echo $prazo_urgencia; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Meios Disponíveis</td>
                                                        <td>
                                                            <?php
                                                            foreach ($meios_disponiveis as $n => $d) {
                                                                echo '<input type="checkbox" name="meio_disponiveis[' . $n . ']" value="1" ' . (($d) ? 'checked' : '') . ' /> ' . MeioRecebimentoNomeCampo($n) . '<br />';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="submit" name="submitGeral" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações Gerais de Saque</button>
                                                            <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <form action="" method="post">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Taxa de Saque</td>
                                                        <td>
                                                            <?php
                                                            if (isset($configuracoes_saque_rendimento['taxas'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rendimento['taxas'] as $meioDB => $taxaDB) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rendimento_taxa_banco[]" class="form-control">
                                                                                <option value="">- Escolher Plataforma -</option>
                                                                                <?php
                                                                                foreach ($meios_saques as $id => $meio) {

                                                                                    $selected = ($id == $meioDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $id . '" ' . $selected . '>' . $meio . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="number" name="rendimento_taxa_percentual[]" value="<?php echo $taxaDB; ?>" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>
                                                            <div class="rendimento_block_taxa_saque">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rendimento_taxa_banco[]" class="form-control">
                                                                            <option value="">- Escolher Plataforma -</option>
                                                                            <?php
                                                                            foreach ($meios_saques as $id => $meio) {
                                                                                echo '<option value="' . $id . '">' . $meio . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="rendimento_taxa_percentual[]" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRendimentoTaxaSaque"><i class="fa fa-plus"></i> Adicionar mais taxas</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mínimo de saque</td>
                                                        <td>

                                                            <?php
                                                            if (isset($configuracoes_saque_rendimento['minimos'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rendimento['minimos'] as $meioDB => $minimoDB) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rendimento_minimo_banco[]" class="form-control">
                                                                                <option value="">- Escolher Plataforma -</option>
                                                                                <?php
                                                                                foreach ($meios_saques as $id => $meio) {

                                                                                    $selected = ($id == $meioDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $id . '" ' . $selected . '>' . $meio . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="rendimento_minimo_valor[]" data-plugin="maskmoney" value="<?php echo $minimoDB; ?>" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>

                                                            <div class="rendimento_block_minimo_saque">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rendimento_minimo_banco[]" class="form-control">
                                                                            <option value="">- Escolher Plataforma -</option>
                                                                            <?php
                                                                            foreach ($meios_saques as $id => $meio) {
                                                                                echo '<option value="' . $id . '">' . $meio . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="rendimento_minimo_valor[]" data-plugin="maskmoney" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRendimentoMinimo"><i class="fa fa-plus"></i> Adicionar mais mínimos</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Liberação de saques</td>
                                                        <td>
                                                            <?php
                                                            if (isset($configuracoes_saque_rendimento['liberacao'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rendimento['liberacao'] as $diaDB => $horarios) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rendimento_dias_semana[]" class="form-control">
                                                                                <option value="">- Escolher o dia -</option>
                                                                                <?php
                                                                                foreach ($dias_semana as $diaN => $diaE) {

                                                                                    $selected = ($diaN == $diaDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $diaN . '" ' . $selected . '>' . $diaE . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <input type="text" name="rendimento_horario_inicial[]" data-plugin="maskinput_hour" value="<?php echo ($horarios[0] < 10) ? '0' . $horarios['0'] : $horarios[0]; ?>" placeholder="Horário Inicial" class="form-control" />
                                                                                </div>
                                                                                <div class="col-md-1">
                                                                                    às
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <input type="text" name="rendimento_horario_final[]" data-plugin="maskinput_hour" value="<?php echo ($horarios[1] < 10) ? '0' . $horarios['1'] : $horarios[1]; ?>" placeholder="Horário Final" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>

                                                            <div class="rendimento_block_horario_liberacao">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rendimento_dias_semana[]" class="form-control">
                                                                            <option value="">- Escolher o dia -</option>
                                                                            <?php
                                                                            foreach ($dias_semana as $diaN => $diaE) {
                                                                                echo '<option value="' . $diaN . '">' . $diaE . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <input type="text" name="rendimento_horario_inicial[]" data-plugin="maskinput_hour" placeholder="Horário Inicial" class="form-control" />
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                às
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="rendimento_horario_final[]" data-plugin="maskinput_hour" placeholder="Horário Final" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRendimentoHorarioLiberacao"><i class="fa fa-plus"></i> Adicionar mais horários</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="submit" name="submitRendimento" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações de Saque de Rendimento</button>
                                                            <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="messages1" role="tabpanel">
                                    <form action="" method="post">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Taxa de Saque</td>
                                                        <td>
                                                            <?php
                                                            if (isset($configuracoes_saque_rede['taxas'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rede['taxas'] as $meioDB => $taxaDB) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rede_taxa_banco[]" class="form-control">
                                                                                <option value="">- Escolher Plataforma -</option>
                                                                                <?php
                                                                                foreach ($meios_saques as $id => $meio) {

                                                                                    $selected = ($id == $meioDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $id . '" ' . $selected . '>' . $meio . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="number" name="rede_taxa_percentual[]" value="<?php echo $taxaDB; ?>" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>
                                                            <div class="rede_block_taxa_saque">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rede_taxa_banco[]" class="form-control">
                                                                            <option value="">- Escolher Plataforma -</option>
                                                                            <?php
                                                                            foreach ($meios_saques as $id => $meio) {
                                                                                echo '<option value="' . $id . '">' . $meio . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="number" name="rede_taxa_percentual[]" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRedeTaxaSaque"><i class="fa fa-plus"></i> Adicionar mais taxas</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mínimo de saque</td>
                                                        <td>

                                                            <?php
                                                            if (isset($configuracoes_saque_rede['minimos'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rede['minimos'] as $meioDB => $minimoDB) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rede_minimo_banco[]" class="form-control">
                                                                                <option value="">- Escolher Plataforma -</option>
                                                                                <?php
                                                                                foreach ($meios_saques as $id => $meio) {

                                                                                    $selected = ($id == $meioDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $id . '" ' . $selected . '>' . $meio . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="rede_minimo_valor[]" data-plugin="maskmoney" value="<?php echo $minimoDB; ?>" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>

                                                            <div class="rede_block_minimo_saque">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rede_minimo_banco[]" class="form-control">
                                                                            <option value="">- Escolher Plataforma -</option>
                                                                            <?php
                                                                            foreach ($meios_saques as $id => $meio) {
                                                                                echo '<option value="' . $id . '">' . $meio . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="rede_minimo_valor[]" data-plugin="maskmoney" class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRedeMinimo"><i class="fa fa-plus"></i> Adicionar mais mínimos</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Liberação de saques</td>
                                                        <td>
                                                            <?php
                                                            if (isset($configuracoes_saque_rede['liberacao'])) {
                                                                echo '<div class="rDB">';
                                                                foreach ($configuracoes_saque_rede['liberacao'] as $diaDB => $horarios) {
                                                            ?>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <select name="rede_dias_semana[]" class="form-control">
                                                                                <option value="">- Escolher o dia -</option>
                                                                                <?php
                                                                                foreach ($dias_semana as $diaN => $diaE) {

                                                                                    $selected = ($diaN == $diaDB) ? 'selected' : '';

                                                                                    echo '<option value="' . $diaN . '" ' . $selected . '>' . $diaE . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <input type="text" name="rede_horario_inicial[]" data-plugin="maskinput_hour" value="<?php echo ($horarios[0] < 10) ? '0' . $horarios['0'] : $horarios[0]; ?>" placeholder="Horário Inicial" class="form-control" />
                                                                                </div>
                                                                                <div class="col-md-1">
                                                                                    às
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <input type="text" name="rede_horario_final[]" data-plugin="maskinput_hour" value="<?php echo ($horarios[1] < 10) ? '0' . $horarios['1'] : $horarios[1]; ?>" placeholder="Horário Final" class="form-control" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>';
                                                            }
                                                            ?>

                                                            <div class="rede_block_horario_liberacao">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <select name="rede_dias_semana[]" class="form-control">
                                                                            <option value="">- Escolher o dia -</option>
                                                                            <?php
                                                                            foreach ($dias_semana as $diaN => $diaE) {
                                                                                echo '<option value="' . $diaN . '">' . $diaE . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <input type="text" name="rede_horario_inicial[]" data-plugin="maskinput_hour" placeholder="Horário Inicial" class="form-control" />
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                às
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <input type="text" name="rede_horario_final[]" data-plugin="maskinput_hour" placeholder="Horário Final" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-info btn-block mt-3 addRedeHorarioLiberacao"><i class="fa fa-plus"></i> Adicionar mais horários</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="submit" name="submitRede" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações de Saque de Rede</button>
                                                            <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="raiz" role="tabpanel">
                                    <form action="" method="post">
                                        <div class="table-responsive">
                                            <table id="" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Pagar a raiz junto com rendimento</td>
                                                        <td>
                                                            <input type="radio" name="pagamento_raiz" value="1" <?php echo ($pagamento_raiz == 1) ? 'checked' : ''; ?>> Sim <br />
                                                            <input type="radio" name="pagamento_raiz" value="0" <?php echo ($pagamento_raiz == 0) ? 'checked' : ''; ?>> Não <br />
                                                            <small>* Caso você habilite <strong>sim</strong>, os botões de cancelamento de contrato, saque <br />de raiz e renovação serão desabilitados no sistema automaticamente.</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Taxa de Cancelamento de Raiz</td>
                                                        <td>
                                                            <input type="number" name="taxa_saque_raiz" class="form-control" value="<?php echo $taxa_saque_raiz; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="submit" name="submitRaiz" value="Atualizar" class="btn btn-success btn-block">Atualizar Configurações de Raiz</button>
                                                            <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->