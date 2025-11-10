Sistema de Controle de Acesso — IHAC LAB-I

Este projeto implementa uma interface web em PHP + JavaScript para controle de acesso via cartões RFID, integrada à API do IHAC LAB-I (UFBA).
O sistema identifica o usuário pelo NFC ID, exibe seus projetos e recursos vinculados, e registra o acesso em tempo real via API.

🚀 Funcionalidades Principais

🔐 Leitura de cartão RFID via porta serial (usando Web Serial API);

👤 Identificação automática do usuário com base no NFCId;

🧩 Listagem de projetos e recursos associados ao usuário via API;

✅ Registro de acessos diretamente na API (/records/acessos);

💬 Interface interativa com feedback visual e confirmações animadas;

🔄 Redirecionamento automático após inatividade (10 segundos);

🖥️ Interface visual moderna com botões circulares e design responsivo.

🧩 Estrutura do Código
📁 Arquivo Principal

index.php
Contém toda a lógica de backend e frontend:

🔸 Seções do código:

PHP (Backend)

Inicia sessão e configurações de API ($API_BASE);

Lê o parâmetro NFCId recebido via URL;

Consulta a API:
https://www.ihaclabi.ufba.br/api.php/records/vwAlocacoes?filter=NFCId,eq,{NFCId};

Processa os registros retornados (usuário, projetos e recursos);

Gera o HTML dinamicamente conforme os dados encontrados.

HTML + CSS

Estrutura principal da página com main-container centralizado;

Estilo visual em amarelo/azul com sombras e botões animados;

Exibe avatar, nome e função do usuário.

JavaScript (Frontend)

Comunicação com a porta serial para leitura do RFID;

Atualiza dinamicamente as listas de Projetos e Recursos;

Permite navegação via setas do teclado:

⬇️ Navegar nas opções

➡️ Confirmar / Avançar

⬅️ Voltar

Registra acessos via fetch() na API IHAC LAB-I.

🧰 Requisitos
💻 Ambiente

Servidor PHP (≥ 7.4)

Acesso à internet para consumir a API pública

Navegador compatível com Web Serial API

✅ Chrome, Edge (versões recentes)

❌ Firefox e Safari ainda não suportam

🧾 API utilizada

Base: https://www.ihaclabi.ufba.br/api.php/records/

Endpoints principais:

/vwAlocacoes — busca de alocações do usuário

/acessos — registro de novo acesso

⚙️ Como Executar o Projeto

Clone o repositório:

git clone https://github.com/seuusuario/controle-acesso-ihac.git
cd controle-acesso-ihac


Inicie um servidor PHP local:

php -S localhost:8000


Acesse no navegador:

http://localhost:8000/index.php


Conecte o dispositivo RFID via USB

O navegador solicitará permissão de acesso à porta serial.

Após a leitura do cartão, o sistema redirecionará automaticamente para index.php?NFCId={codigo}.

🔄 Fluxo de Funcionamento

Usuário aproxima o cartão RFID;

O navegador lê o código (NFCId) e recarrega a página com esse parâmetro;

O PHP consulta a API e carrega:

Nome, função e imagem do usuário;

Projetos e recursos disponíveis;

O usuário navega com as setas e confirma o recurso acessado;

O sistema registra o acesso via API e mostra mensagem de sucesso
