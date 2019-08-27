SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `greenpark`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `Id_cliente` int(10) NOT NULL,
  `Id_endereco` int(10) NOT NULL,
  `Id_esposa` int(10) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `rg` varchar(100) NOT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `celular` varchar(100) NOT NULL,
  `profissao` varchar(100) DEFAULT NULL,
  `localTrabalho` varchar(100) DEFAULT NULL,
  `renda` varchar(100) NOT NULL,
  `estadoCivil` varchar(150) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `img_rg` varchar(100) NOT NULL,
  `img_cpf` varchar(100) NOT NULL,
  `img_casamento` varchar(100) DEFAULT NULL,
  `img_residencia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `corretor`
--

CREATE TABLE `corretor` (
  `Id_corretor` int(10) NOT NULL,
  `Id_endereco` int(10) NOT NULL,
  `telefone` varchar(100) DEFAULT NULL,
  `celular` varchar(100) NOT NULL,
  `creci` varchar(100) NOT NULL,
  `cnpj` varchar(150) DEFAULT NULL,
  `empresa` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `Id_endereco` int(10) NOT NULL,
  `cep` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `numero` varchar(100) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `lote`
--

CREATE TABLE `lote` (
  `Id_lote` int(11) NOT NULL,
  `quadra` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `bloco` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `metragem` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `numeroLote` int(11) NOT NULL,
  `valor` double NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'livre',
  `infoPosisao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `infoTamanho` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rotate` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0deg'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estrutura da tabela `negociacao`
--

CREATE TABLE `negociacao` (
  `Id_negociacao` int(15) NOT NULL,
  `Id_usuario` int(15) NOT NULL,
  `Id_lote` int(15) NOT NULL,
  `Id_cliente` int(15) DEFAULT NULL,
  `Id_valorFinanciamento` int(15) DEFAULT NULL,
  `valorEntrada` int(15) NOT NULL,
  `vencimentoEntrada` date NOT NULL,
  `numParcela` int(15) NOT NULL,
  `numEntrada` int(10) NOT NULL DEFAULT '1',
  `vencimentoParcela` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'livre',
  `dataNegociacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `juros` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `sitecadastro`
--

CREATE TABLE `sitecadastro` (
  `Id_sitecadastro` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rg` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endereco` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bairro` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profissao` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trabalho` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prestacao` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entrada` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `renda` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intencao` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `informacoes` text COLLATE utf8_unicode_ci,
  `tem_corretor` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nome_corretor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creci` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `Id_usuario` int(10) NOT NULL,
  `Id_corretor` int(10) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `nivel` varchar(100) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estrutura da tabela `valorfinanciamento`
--

CREATE TABLE `valorfinanciamento` (
  `Id_valorFinanciamento` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `parcela_12` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_24` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_36` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_48` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_60` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_72` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_84` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_96` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_108` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parcela_120` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Id_cliente`);

--
-- Indexes for table `corretor`
--
ALTER TABLE `corretor`
  ADD PRIMARY KEY (`Id_corretor`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`Id_endereco`);

--
-- Indexes for table `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`Id_lote`);

--
-- Indexes for table `negociacao`
--
ALTER TABLE `negociacao`
  ADD PRIMARY KEY (`Id_negociacao`);

--
-- Indexes for table `sitecadastro`
--
ALTER TABLE `sitecadastro`
  ADD PRIMARY KEY (`Id_sitecadastro`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- Indexes for table `valorfinanciamento`
--
ALTER TABLE `valorfinanciamento`
  ADD PRIMARY KEY (`Id_valorFinanciamento`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `Id_cliente` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `corretor`
--
ALTER TABLE `corretor`
  MODIFY `Id_corretor` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `Id_endereco` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lote`
--
ALTER TABLE `lote`
  MODIFY `Id_lote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `negociacao`
--
ALTER TABLE `negociacao`
  MODIFY `Id_negociacao` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sitecadastro`
--
ALTER TABLE `sitecadastro`
  MODIFY `Id_sitecadastro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_usuario` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valorfinanciamento`
--
ALTER TABLE `valorfinanciamento`
  MODIFY `Id_valorFinanciamento` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;




-- --------------------------------------------------------

CREATE TABLE balao (
   Id_balao int(10) NOT NULL AUTO_INCREMENT,
   Id_negociacao int(10) NOT NULL,
   valor varchar(100) NOT NULL,
   data DATE NOT NULL,
   PRIMARY KEY (Id_balao),
   FOREIGN KEY (Id_negociacao) REFERENCES negociacao(Id_negociacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

