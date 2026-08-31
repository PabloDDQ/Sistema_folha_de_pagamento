<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\DAO\ColaboradorDAO;
use App\DAO\DepartamentoDAO;
use App\DAO\FolhaPagamentoDAO;
use App\DAO\SenioridadeDAO;
use App\Model\Colaborador;
use App\Model\Departamento;
use App\Model\FolhaPagamento;
use App\Model\SenioridadeEnum;
use App\Service\FolhaPagamentoService;

function exibirLinha(string $texto): void
{
    echo $texto . PHP_EOL;
}

function lerEntrada(string $prompt): string
{
    echo $prompt;
    $entrada = trim((string) fgets(STDIN));
    return $entrada;
}

function listarDepartamentos(): array
{
    $dao = new DepartamentoDAO();
    return $dao->read();
}

function listarColaboradores(): array
{
    $dao = new ColaboradorDAO();
    return $dao->read();
}

function selecionarDepartamento(): ?Departamento
{
    $departamentos = listarDepartamentos();

    if (empty($departamentos)) {
        exibirLinha('Nenhum departamento cadastrado.');
        return null;
    }

    exibirLinha('Departamentos disponíveis:');
    foreach ($departamentos as $indice => $departamento) {
        $id = $departamento['ID_departamento'];
        $nome = $departamento['nome_departamento'];
        exibirLinha(sprintf(' [%d] %s (ID: %d)', $indice + 1, $nome, $id));
    }

    $opcao = (int) lerEntrada('Escolha o departamento: ');
    $indice = $opcao - 1;

    if (!isset($departamentos[$indice])) {
        exibirLinha('Opção inválida.');
        return null;
    }

    $departamento = new Departamento($departamentos[$indice]['nome_departamento']);
    $departamento->setId((int) $departamentos[$indice]['ID_departamento']);

    return $departamento;
}

function listarSenioridades(): array
{
    $dao = new SenioridadeDAO();
    return $dao->read();
}

function selecionarSenioridade(): SenioridadeEnum
{
    $senioridades = listarSenioridades();

    if (empty($senioridades)) {
        throw new RuntimeException('Nenhuma senioridade cadastrada no banco.');
    }

    exibirLinha('Senioridades disponíveis no banco:');
    foreach ($senioridades as $indice => $senioridade) {
        exibirLinha(sprintf(' [%d] %s (ID %d)', $indice + 1, ucfirst($senioridade['senerioridade']), (int) $senioridade['ID_senioridade']));
    }

    $opcao = (int) lerEntrada('Escolha a senioridade: ');
    $indice = $opcao - 1;

    if (!isset($senioridades[$indice])) {
        throw new InvalidArgumentException('Opção inválida de senioridade.');
    }

    $valor = $senioridades[$indice]['senerioridade'];
    return SenioridadeEnum::tryFrom($valor) ?? throw new InvalidArgumentException('Senioridade inválida no banco.');
}

function cadastrarDepartamento(): void
{
    $nome = lerEntrada('Nome do departamento: ');

    if ($nome === '') {
        exibirLinha('O nome do departamento não pode ficar vazio.');
        return;
    }

    $departamento = new Departamento($nome);
    $dao = new DepartamentoDAO();
    $dao->create($departamento);

    exibirLinha('Departamento cadastrado com sucesso.');
}

function listarDepartamentosConsole(): void
{
    $departamentos = listarDepartamentos();

    if (empty($departamentos)) {
        exibirLinha('Nenhum departamento cadastrado.');
        return;
    }

    exibirLinha('Lista de departamentos:');
    foreach ($departamentos as $departamento) {
        exibirLinha(sprintf(' - ID %d | %s', $departamento['ID_departamento'], $departamento['nome_departamento']));
    }
}

function cadastrarColaborador(): void
{
    $nome = lerEntrada('Nome do colaborador: ');
    $cargo = lerEntrada('Cargo específico: ');

    if ($nome === '' || $cargo === '') {
        exibirLinha('Nome e cargo são obrigatórios.');
        return;
    }

    $departamento = selecionarDepartamento();
    if ($departamento === null) {
        return;
    }

    try {
        $senioridade = selecionarSenioridade();
        $colaborador = new Colaborador($nome, $cargo, $departamento, $senioridade);
        $dao = new ColaboradorDAO();
        $dao->create($colaborador);

        exibirLinha('Colaborador cadastrado com sucesso.');
    } catch (InvalidArgumentException $e) {
        exibirLinha($e->getMessage());
    }
}

function listarColaboradoresConsole(): void
{
    $colaboradores = listarColaboradores();

    if (empty($colaboradores)) {
        exibirLinha('Nenhum colaborador cadastrado.');
        return;
    }

    exibirLinha('Lista de colaboradores:');
    foreach ($colaboradores as $colaborador) {
        exibirLinha(sprintf(' - ID %d | %s | %s | Departamento ID %d | Senioridade ID %d',
            $colaborador['ID_colaborador'],
            $colaborador['nome_colaborador'],
            $colaborador['cargo_especifico'],
            $colaborador['departamento_ID'],
            $colaborador['senioridade_ID']
        ));
    }
}

function calcularPagamento(): void
{
    $colaboradores = listarColaboradores();

    if (empty($colaboradores)) {
        exibirLinha('Nenhum colaborador cadastrado para pagamento.');
        return;
    }

    exibirLinha('Colaboradores disponíveis:');
    foreach ($colaboradores as $indice => $colaborador) {
        exibirLinha(sprintf(' [%d] %s (%s)', $indice + 1, $colaborador['nome_colaborador'], $colaborador['cargo_especifico']));
    }

    $opcao = (int) lerEntrada('Escolha o colaborador: ');
    $indice = $opcao - 1;

    if (!isset($colaboradores[$indice])) {
        exibirLinha('Colaborador inválido.');
        return;
    }

    $colaboradorSelecionado = $colaboradores[$indice];
    $departamento = new Departamento('');
    $departamento->setId((int) $colaboradorSelecionado['departamento_ID']);

    $senioridade = SenioridadeEnum::fromId((int) $colaboradorSelecionado['senioridade_ID']);
    $colaborador = new Colaborador(
        $colaboradorSelecionado['nome_colaborador'],
        $colaboradorSelecionado['cargo_especifico'],
        $departamento,
        $senioridade
    );
    $colaborador->setId((int) $colaboradorSelecionado['ID_colaborador']);

    $dias = (int) lerEntrada('Dias trabalhados (1 a 30): ');
    $extra = (float) lerEntrada('Valor extra: ');

    $folha = new FolhaPagamento($colaborador, $dias, $extra, 0, new DateTimeImmutable());
    $service = new FolhaPagamentoService(new FolhaPagamentoDAO());

    try {
        $pagamento = $service->registrarPagamento($folha);
        exibirLinha('Pagamento registrado com sucesso.');
        exibirLinha(sprintf('Total: R$ %.2f', $pagamento->getTotalPagamento()));
    } catch (Throwable $e) {
        exibirLinha($e->getMessage());
    }
}

function mostrarMenu(): void
{
    exibirLinha('');
    exibirLinha('=== CLI - Sistema de Folha de Pagamento ===');
    exibirLinha('1. Cadastrar departamento');
    exibirLinha('2. Listar departamentos');
    exibirLinha('3. Cadastrar colaborador');
    exibirLinha('4. Listar colaboradores');
    exibirLinha('5. Registrar pagamento');
    exibirLinha('0. Sair');
}

function executarMenuInterativo(): void
{
    while (true) {
        mostrarMenu();
        $opcao = lerEntrada('Selecione uma opção: ');

        switch ($opcao) {
            case '1':
                cadastrarDepartamento();
                break;
            case '2':
                listarDepartamentosConsole();
                break;
            case '3':
                cadastrarColaborador();
                break;
            case '4':
                listarColaboradoresConsole();
                break;
            case '5':
                calcularPagamento();
                break;
            case '0':
                exibirLinha('Encerrando sistema...');
                exit(0);
            default:
                exibirLinha('Opção inválida.');
                break;
        }
    }
}

function mostrarUso(): void
{
    exibirLinha('Uso do programa:');
    exibirLinha(' php App/index.php');
    exibirLinha(' php App/index.php --help');
    exibirLinha(' php App/index.php departamentos');
    exibirLinha(' php App/index.php colaboradores');
    exibirLinha(' php App/index.php departamento-novo');
    exibirLinha(' php App/index.php colaborador-novo');
    exibirLinha(' php App/index.php pagamento');
}

function executarComando(array $argv): void
{
    $comando = $argv[1] ?? 'menu';

    if ($comando === '--help' || $comando === '-h') {
        mostrarUso();
        return;
    }

    switch ($comando) {
        case 'menu':
            executarMenuInterativo();
            break;
        case 'departamentos':
            listarDepartamentosConsole();
            break;
        case 'colaboradores':
            listarColaboradoresConsole();
            break;
        case 'departamento-novo':
            cadastrarDepartamento();
            break;
        case 'colaborador-novo':
            cadastrarColaborador();
            break;
        case 'pagamento':
            calcularPagamento();
            break;
        default:
            mostrarUso();
            break;
    }
}

executarComando($argv);