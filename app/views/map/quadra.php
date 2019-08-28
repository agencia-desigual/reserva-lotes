<?php $this->view("map/include/header"); ?>

<!-- Modal - Reservar -->
<div class="modal centraliza-itens" id="modal_reserva" style="display: none">

    <!-- Item -->
    <div class="item">

        <div class="header">
            <div class="bloco">
                <h3>Bloco <span id="txt_bloco">B</span> - Lote <span id="txt_lote">12</span></h3>
            </div>
            <div class="numeros">
                <h1>Reserva de Lote</h1>

                <ol class="progress" data-steps="4">
                    <li class="active" id="topo_etapa1">
                        <span class="step"><span>1</span></span>
                    </li>
                    <li class="" id="topo_etapa2">
                        <span class="step"><span>2</span></span>
                    </li>
                    <li class="" id="topo_etapa3">
                        <span class="step"><span>3</span></span>
                    </li>
                </ol>
            </div>
        </div>

        <!-- Conteudo com Scroll -->
        <div class="conteudo">

            <!-- Etapa 1 -->
            <div id="etapa1" style="display: block">
                <form id="form_etapa1">
                    <div class="row">
                        <!-- Valor do Lote -->
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>Valor do Lote</label>
                                <p id="txt_valorLote">R$200.000,00</p>
                            </div>
                        </div>

                        <!-- Vendedor -->
                        <div class="col-2">
                            <div class="p-l-20">
                                <label>Corretor Responsável</label>
                                <select name="corretor" id="input_corretor" required>
                                    <?php if($_SESSION["usuario"]->nivel == "user"): ?>
                                        <option selected value="<?= $_SESSION["usuario"]->Id_usuario; ?>"><?= $_SESSION["usuario"]->nome; ?></option>
                                    <?php else: ?>
                                        <option selected disabled>Selecione o corretor</option>
                                        <?php foreach ($corretores as $corretor): ?>
                                            <option selected value="<?= $corretor->Id_usuario; ?>"><?= $corretor->nome; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Valor do Lote -->
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>Valor da Entrada</label>
                                <input type="tel" class="maskValor" onblur="buscaInfoFinanciamento(this.value)" id="input_valorEntrada" name="valorEntrada" />
                            </div>
                        </div>

                        <!-- Vendedor -->
                        <div class="col-2">
                            <div class="p-l-20">
                                <label>Numero de Parcelas</label>
                                <select name="numEntrada">
                                    <option value="1" selected>Á vista</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- BALAO -->
                    <?php if($_SESSION["usuario"]->nivel == "administrador"): ?>
                        <div class="row">
                            <h3 class="centraliza-itens">Balão</h3>
                            <!-- Valor total do balão -->
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Valor total</label>
                                    <input type="text" class="maskValor" id="input_valorTotalBalao" name="valorTotalBalao" />
                                </div>
                            </div>

                            <!-- Numero de paecelas -->
                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Número de parcelas</label>
                                    <select id="numParcelasBalao" name="numParcelasBalao"onchange="parcelasBalao(this.value)">
                                        <option selected disabled>Selecione</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="parcelasBalao">

                            <?php for($i = 1; $i <= 10; $i++): ?>

                                <div id="balaoParcela<?=$i?>" style="display: none" class="row">
                                    <div class="col-2">
                                        <div class="p-r-20">
                                            <label>Valor da <?=$i?>º parcela</label>
                                            <input type="text" class="maskValorVigula" id="input_valorParcelaBalao<?=$i?>" name="valorParcelaBalao<?=$i?>" />
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="p-l-20">
                                            <label>Data da <?=$i?>º parcela</label>
                                            <input type="date" id="input_dataParcela<?=$i?>" name="dataParcela<?=$i?>" value="<?= date("Y-m-d",strtotime("+{$i} years",strtotime(date("Y-m-d")))); ?>" />
                                        </div>
                                    </div>
                                </div>

                            <?php endfor; ?>

                        </div>
                    <?php endif; ?>
                    <!-- FIM BALAO -->

                    <div class="row">
                        <!-- Vendedor -->
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>Vencimento Entrada</label>
                                <input type="date" id="input_vencimentoEntrada" name="vencimentoEntrada" min="<?= date("Y-m-d"); ?>" />
                            </div>
                        </div>

                        <!-- Valor do Lote -->
                        <div class="col-2">
                            <div class="p-l-20">
                                <label>Valor a ser financiado</label>
                                <p id="txt_valorFinanciado">R$0,00</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if($_SESSION["usuario"]->nivel == "user"): ?>

                            <!-- Valor do Lote -->
                            <div class="col-1">
                                <label>Quantidade de Parcelas</label>
                                <select name="parcelas" id="input_parcelas" onchange="selecionaNumParcelas(this.value)">
                                    <option value="0" selected>Pagamento á vista</option>
                                    <option value="12">12 Messes</option>
                                    <option value="24">24 Messes</option>
                                    <option value="36">36 Messes</option>
                                    <option value="48">48 Messes</option>
                                    <option value="60">60 Messes</option>
                                    <option value="72">72 Messes</option>
                                    <option value="84">84 Messes</option>
                                    <option value="96">96 Messes</option>
                                    <option value="108">108 Messes</option>
                                    <option value="120">120 Messes</option>
                                </select>
                            </div>

                            <input name="juros" type="hidden" value="1" />
                        <?php else: ?>
                            <!-- Valor do Lote -->
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Quantidade de Parcelas</label>
                                    <select name="parcelas" id="input_parcelas" onchange="selecionaNumParcelas(this.value)">
                                        <option value="0" selected>Pagamento á vista</option>
                                        <option value="12">12 Messes</option>
                                        <option value="24">24 Messes</option>
                                        <option value="36">36 Messes</option>
                                        <option value="48">48 Messes</option>
                                        <option value="60">60 Messes</option>
                                        <option value="72">72 Messes</option>
                                        <option value="84">84 Messes</option>
                                        <option value="96">96 Messes</option>
                                        <option value="108">108 Messes</option>
                                        <option value="120">120 Messes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Juros</label>
                                    <select name="juros" id="input_juros" onchange="alteraJuros(this.value)">
                                        <option value="1" selected>Cobrar Juros</option>
                                        <option value="0">Não cobrar Juros</option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <!-- Valor do Lote -->
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>Valor da Parcela</label>
                                <p id="txt_valorParcela">R$0,00</p>
                            </div>
                        </div>

                        <!-- Vendedor -->
                        <div class="col-2">
                            <div class="p-l-20">
                                <label>Vencimento 1ª Parcela</label>
                                <input type="date" name="vencimentoParcela" id="input_vencimentoParcela" min="<?= date("Y-m-d"); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row btn">

                    </div>

                    <div class="row btn final" style="text-align: center;">
                        <button type="button" class="cancela" onclick="modais('modal_reserva','fecha')">Cancelar</button>
                        <button type="submit" id="btn_etapa1">Continuar</button>
                    </div>
                </form>
            </div>

            <!-- Etapa 2 -->
            <div id="etapa2" style="display: none">
                <h4>Informações do Cliente</h4>

                <form id="form_etapa2">
                    <div class="row">
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>CPF</label>
                                <input type="tel" name="cpf" id="input_cpf" onblur="buscaCliente(this.value)" class="maskCPF" />
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="p-l-20">
                                <label>RG</label>
                                <input type="tel" name="rg" id="input_rg" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <div class="p-r-20">
                                <label>Nome</label>
                                <input type="text" name="nome" id="input_nome" />
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="p-l-20">
                                <label>Estado Civil</label>
                                <select name="estadoCivil" onchange="verificaEstadoCivil(this.value)" id="input_estadoCivil">
                                    <option selected disabled>Selecione o estado civil</option>
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viúvo">Viúvo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-1">
                            <label>E-mail</label>
                            <input type="email" name="email" id="input_email" />
                        </div>
                    </div>

                    <div id="div_someCliente" style="display: block;">
                        <div class="row">
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Renda</label>
                                    <input type="tel" name="renda" class="maskValor" id="input_renda" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Data de Nascimento</label>
                                    <input type="date" name="dataNascimento" id="input_dataNascimento" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Local de Trabalho</label>
                                    <input type="text" name="localTrabalho" id="input_localTrabalho" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Profissão</label>
                                    <input type="text" name="profissao" id="input_profissao" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Telefone</label>
                                    <input type="tel" name="telefone" class="maskTel" id="input_telefone" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Celular</label>
                                    <input type="tel" name="celular" class="maskCel" id="input_celular" />
                                </div>
                            </div>
                        </div>




                        <div id="div_casado" class="p-t-20 p-b-20" style="display: none;">
                            <h4 style="clear: both; padding-top: 30px;">Informações da(o) Esposa(o)</h4>

                            <div class="row">
                                <div class="col-2">
                                    <div class="p-r-20">
                                        <label>CPF</label>
                                        <input type="tel" name="esp_cpf" id="input_esp_cpf" class="maskCPF" />
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="p-l-20">
                                        <label>RG</label>
                                        <input type="tel" name="esp_rg" id="input_esp_rg" />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-2">
                                    <div class="p-r-20">
                                        <label>Nome</label>
                                        <input type="text" name="esp_nome" id="input_esp_nome" />
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="p-l-20">
                                        <label>E-mail</label>
                                        <input type="email" name="esp_email" id="input_esp_email" />
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="esp_estadoCivil" value="casado" />

                            <div class="row">
                                <div class="col-2">
                                    <div class="p-r-20">
                                        <label>Renda</label>
                                        <input type="tel" name="esp_renda" class="maskValor" id="input_esp_renda" />
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="p-l-20">
                                        <label>Data de Nascimento</label>
                                        <input type="date" name="esp_dataNascimento" id="input_esp_dataNascimento" />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-2">
                                    <div class="p-r-20">
                                        <label>Local de Trabalho</label>
                                        <input type="text" name="esp_localTrabalho" id="input_esp_localTrabalho" />
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="p-l-20">
                                        <label>Profissão</label>
                                        <input type="text" name="esp_profissao" id="input_esp_profissao" />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-2">
                                    <div class="p-r-20">
                                        <label>Telefone</label>
                                        <input type="tel" name="esp_telefone" class="maskTel" id="input_esp_telefone" />
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="p-l-20">
                                        <label>Celular</label>
                                        <input type="tel" name="esp_celular" class="maskCel" id="input_esp_celular" />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-1">
                                    <label>Foto do RG</label>
                                    <input type="file" name="esp_arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1">
                                    <label>Foto do CPF</label>
                                    <input type="file" name="esp_arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                                </div>
                            </div>
                        </div>

                        






                        <div class="row">
                            <h4 style="clear: both; padding-top: 30px;">Informações do Endereço</h4>

                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>CEP</label>
                                    <input type="tel" name="cep" id="input_cep" onblur="buscaCEP(this.value)" class="maskCEP" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Bairro</label>
                                    <input type="text" name="bairro" id="input_bairro" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" id="input_cidade" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Estado</label>
                                    <input type="text" name="estado" id="input_estado" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="p-r-20">
                                    <label>Endereço</label>
                                    <input type="text" name="endereco" id="input_endereco" />
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="p-l-20">
                                    <label>Número</label>
                                    <input type="text" name="numero" id="input_numero" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label>Complemento</label>
                                <input type="text" name="complemento" id="input_complemento" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label>Foto do RG</label>
                                <input type="file" name="arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label>Foto do CPF</label>
                                <input type="file" name="arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                            </div>
                        </div>

                        <div class="row" id="div_certidao" style="display: none;">
                            <div class="col-1">
                                <label>Foto da Certidão de Casamento</label>
                                <input type="file" name="arquivo_casamento" accept="image/*" capture="camera" class="dropify" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label>Foto do Comprovante de Residencia</label>
                                <input type="file" name="arquivo_residencia" accept="image/*" capture="camera" class="dropify" />
                            </div>
                        </div>
                    </div>

                    <div class="row btn final" style="text-align: center;">
                        <button type="button" class="cancela" onclick="cancelarReserva()">Cancelar</button>
                        <button type="submit" id="btn_etapa2">Continuar</button>
                    </div>
                </form>
            </div>

            <!-- Etapa 3 -->
            <div id="etapa3" style="display: none">
                <h4>Finalização</h4>

                <div class="row">
                    <div class="col-2 boleto">
                        <a href="" id="link_entrada" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                            <p>Entrada</p>
                        </a>
                    </div>
                    <div class="col-2 boleto">
                        <a href="" id="link_parcela" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                            <p>1ª Parcela</p>
                        </a>
                    </div>
                </div>

                <div class="row p-t-40">
                    <div class="col-2">
                        <a href="" id="link_contrato" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/download.png" />
                            <p class="bod">Contrato</p>
                        </a>
                    </div>
                    <div class="col-2">
                        <!-- <a href="">
                            <img src="<?= BASE_STORANGE; ?>assets/img/download.png" />
                            <p class="bod">Contrato</p>
                        </a> -->
                    </div>
                </div>


                <div class="row btn final" style="text-align: center; padding-top: 80px;">
                    <?php if($usuario->nivel == "administrador"): ?>
                        <button type="button" class="cancela" onclick="cancelarReserva()">Cancelar</button>
                        <button type="button" onclick="venderLote()">Vender</button>
                    <?php endif; ?>

                    <button type="button" onclick="modais('modal_reserva','fecha')">Reservar</button>
                </div>

            </div>
        </div>
        <!-- end >> scroll -->
    </div>
    <!-- end >> item -->

    <div class="fecha" onclick="modais('modal_reserva','fecha')"></div>
</div>





<!-- Modal - Vizualizar -->
<div class="modal centraliza-itens" id="modal_vizualizar" style="display: none;">

    <!-- Item -->
    <div class="item">
        <div class="header">
            <div class="bloco">
                <h3>Bloco <span id="txt_bloco_mv">B</span> - Lote <span id="txt_lote_mv">12</span></h3>
            </div>
            <div class="numeros">
                <h1 id="txt_status_mv">RESERVADO</h1>
                <p><span id="txt_medida_mv">0</span>m²</p>
            </div>
        </div>

        <!-- Conteudo com Scroll -->
        <div class="conteudo">
            <div class="row">
                <!-- Valor do Lote -->
                <div class="col-2">
                    <div class="p-r-20">
                        <label>Valor do Lote</label>
                        <p id="txt_valorLote_mv">R$200.000,00</p>
                    </div>
                </div>

                <!-- Vendedor -->
                <div class="col-2">
                    <div class="p-l-20">
                        <label>Corretor Responsável</label>
                        <p id="txt_corretor_mv">Jaison Mendes</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Valor do Lote -->
                <div class="col-2">
                    <div class="p-r-20">
                        <label>Cliente</label>
                        <p id="txt_cliente_mv">Jaime Nunes</p>
                    </div>
                </div>

                <!-- Vendedor -->
                <div class="col-2">
                    <div class="p-l-20">
                        <label>Data da Negociação</label>
                        <p id="txt_data_mv">10/10/2010 ás 10:15</p>
                    </div>
                </div>
            </div>
            
            
            
            <div id="divDownload" style="display: none;">
                <div class="row">
                    <div class="col-2 boleto">
                        <a href="" id="link_entrada_v" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                            <p>Entrada</p>
                        </a>
                    </div>
                    <div class="col-2 boleto">
                        <a href="" id="link_parcela_v" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                            <p>1ª Parcela</p>
                        </a>
                    </div>
                </div>

                <div class="row p-t-40">
                    <div class="col-2">
                        <a href="" id="link_contrato_v" target="_blank">
                            <img src="<?= BASE_STORANGE; ?>assets/img/download.png" />
                            <p class="bod">Contrato</p>
                        </a>
                    </div>
                    <div class="col-2">
                        <!-- <a href="">
                            <img src="<?= BASE_STORANGE; ?>assets/img/download.png" />
                            <p class="bod">Contrato</p>
                        </a> -->
                    </div>
                </div>
            </div>


            <div class="row btn final" style="text-align: center; padding-top: 80px;">
                <?php if($usuario->nivel == "administrador"): ?>
                    <button type="button" onclick="cancelarReserva()" class="cancela">Cancelar</button>
                    <button type="button" onclick="venderLote()" id="btn_vender_mv">Vender</button>
                <?php endif; ?>
                <button type="button" onclick="modais('modal_vizualizar','fecha')">Fechar</button>
            </div>
        </div>
        <!-- end >> scroll -->
    </div>
    <!-- end >> item -->

    <div class="fecha" onclick="modais('modal_vizualizar','fecha')"></div>
</div>






<div class="gambis">
    <!-- Quadra / Salva os conteudo -->
    <section class="pg-quadra <?= ($quadra == 1) ? "qd1" : "qd2"; ?>">
        <!-- Todos os lotes desta quadra -->
        <div class="tudo">
            <!-- LOTES -->
            <?php if ($lotes != null):
                foreach ($lotes as $lt):

                    $posi = explode(",", $lt->infoPosisao);
                    $tam = explode(",", $lt->infoTamanho);
                    ?>

                    <div class="lote<?php if ($lt->status != "livre"){echo " " . $lt->status;} ?>"
                         onclick="abreModal('<?= $lt->Id_lote; ?>')"
                         id="lt_<?= $lt->Id_lote; ?>"
                         style="width: <?= $tam[0]; ?>px; height: <?= $tam[1]; ?>px; top: <?= $posi[0]; ?>px; left: <?= $posi[1]; ?>px; transform: rotate(<?= $lt->rotate; ?>);">
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
            <!-- END >> LOTES -->
        </div>

        <!-- Mapa do local -->
        <img src="<?= $imagem; ?>" />
    </section>
    <!-- END >> Conteudo -->
</div>





<?php $this->view("map/include/footer"); ?>

