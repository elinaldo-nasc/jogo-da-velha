# 🎮 Jogo da Velha

[![PHP](https://img.shields.io/badge/PHP-7.4+-blue.svg)](https://php.net)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26-orange.svg)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6-blue.svg)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow.svg)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

Um jogo da velha completo e elegante desenvolvido com PHP, HTML, CSS e JavaScript. Interface moderna com tema dark, IA inteligente e responsividade total.

## 🎮 Características

- **Interface moderna** com tema dark e cores neon
- **Lógica completa** de vitória e empate
- **Alternância de jogadores** (X e O)
- **Placar visual** com contador de vitórias
- **Modo single player** vs IA inteligente
- **Botão de reset** para novo jogo
- **Mensagens coloridas** para diferentes resultados
- **Responsivo** para mobile e desktop

## 🎨 Visual

- **Tema dark** com fundo escuro
- **Azul ciano** para jogador X e vitórias
- **Verde neon** para jogador O
- **Lilas** para empates e botão de modo
- **Efeitos de brilho** e transições suaves
- **Placar elegante** com bordas brilhantes

## 🚀 Como usar

1. Coloque os arquivos em um servidor web (XAMPP, WAMP, etc.)
2. Acesse `game.php` no navegador
3. **Modo 2 Jogadores**: Jogue normalmente alternando entre X e O
4. **Modo vs IA**: Clique em "Modo" para alternar, você joga como X
5. **Placar**: Veja quantas vezes cada jogador ganhou
6. Divirta-se jogando!

## 🤖 IA Inteligente

A IA (jogador O) utiliza uma estratégia avançada:
- **Tenta ganhar** quando possível
- **Bloqueia o jogador** quando necessário  
- **Prioriza centro** (melhor posição)
- **Escolhe cantos** depois
- **Laterais** por último

Oferece um desafio real e não é fácil de vencer!

## 📁 Arquivos

- `game.php` - Arquivo principal com HTML, PHP e JavaScript
- `style.css` - Estilos do jogo com responsividade
- `README.md` - Documentação completa
- `.gitignore` - Ignora arquivos desnecessários

## 🛠️ Tecnologias

- **PHP 7.4+** - Backend e lógica do jogo
- **HTML5** - Estrutura semântica
- **CSS3** - Estilos modernos e responsivos
- **JavaScript ES6+** - Interatividade e AJAX
- **Sessions** - Persistência de dados

## 📸 Screenshots

### Desktop
- Interface dark elegante com placar visual
- Botões com efeitos hover e transições suaves

### Mobile
- Layout responsivo otimizado para touch
- Tabuleiro adaptado para telas pequenas

## 🚀 Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/elinaldo-nasc/jogo-da-velha.git
   ```

2. **Configure o servidor:**
   - XAMPP, WAMP, LAMP ou qualquer servidor com PHP
   - Coloque os arquivos na pasta do servidor

3. **Acesse o jogo:**
   - Abra `http://localhost/jogo-da-velha/game.php`
   - Ou acesse diretamente o arquivo no navegador

## 🎯 Como Jogar

### Modo 2 Jogadores
1. Clique em uma célula vazia para fazer sua jogada
2. Os jogadores alternam automaticamente entre X e O
3. Primeiro a completar uma linha, coluna ou diagonal vence!

### Modo vs IA
1. Clique em "Modo" para alternar para "vs IA"
2. Você joga como X, a IA joga como O
3. A IA é inteligente e oferece um bom desafio!

## 🔧 Requisitos

- **PHP 7.4+** (para sessions e funcionalidades modernas)
- **Servidor web** (Apache, Nginx, etc.)
- **Navegador moderno** com suporte a JavaScript ES6+

## 📝 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 👨‍💻 Autor

**Elinaldo Nascimento**
- GitHub: [@elinaldo-nasc](https://github.com/elinaldo-nasc)
- Email: 

## 🤝 Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para:

1. Fazer um fork do projeto
2. Criar uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abrir um Pull Request

## 📈 Roadmap

- [ ] Diferentes níveis de dificuldade da IA
- [ ] Modo torneio com múltiplos jogadores
- [ ] Estatísticas detalhadas
- [ ] Temas personalizáveis
- [ ] Sons e efeitos sonoros
- [ ] Modo online multiplayer

## 🐛 Reportar Bugs

Se encontrar algum bug, por favor abra uma [issue](https://github.com/elinaldo-nasc/jogo-da-velha/issues) com:
- Descrição do problema
- Passos para reproduzir
- Screenshots (se aplicável)
- Informações do navegador/sistema

