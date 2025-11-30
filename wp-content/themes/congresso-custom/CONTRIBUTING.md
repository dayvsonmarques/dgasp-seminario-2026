# Padrão de desenvolvimento do tema Congresso Custom

## Regras obrigatórias

- Nunca utilizar CSS inline (style="...") em nenhum elemento HTML.
- Todo o CSS deve ser aplicado exclusivamente via classes.
- Utilizar o padrão BEM (Block Element Modifier) para nomear todas as classes CSS.
- Exemplo de BEM: .banner__col, .banner__col--text, .banner__title, .banner__subtitle, .banner__date
- Se precisar de modificadores, utilize o formato: .block__element--modifier
- Manter o código limpo, sem duplicidade de estilos.
- Centralizar regras e boas práticas neste arquivo para consulta futura.

## Referência rápida BEM
- Block: componente principal (ex: banner)
- Element: parte do componente (ex: banner__col)
- Modifier: variação do elemento (ex: banner__col--text)

## Exemplos
```html
<div class="banner__col banner__col--text"></div>
<h1 class="banner__title"></h1>
```

```css
.banner__col {}
.banner__col--text {}
.banner__title {}
```

## Manutenção
- Sempre revisar este arquivo antes de criar novos componentes ou editar existentes.
- Se novas regras forem necessárias, adicionar aqui e comunicar à equipe.
