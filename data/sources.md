# Sources for catalog

## Refactoring.com

The following jquery generated the catalog data from Martin Fowler's refactoring.com:

```
var catalog=[];$('.entry').each(function(i,v) { catalog.push({name:$(v).find('h2').text(),url:"https://refactoring.com" + $(v).find('a').attr('href')}); });console.log(JSON.stringify(catalog));
```

## Refactoring.guru

The following javascript generated the catalog data from refactoring.guru:

```
var catalog=[];$('.catalog-list li a').each(function(i,v) { catalog.push({name:$(v).text(),url:"https://refactoring.guru" + $(v).attr('href')}); }); console.log(JSON.stringify(catalog));
```

## Combining them

Manually combine the two catalog arrays.

Then shuffle entire catalog to randomize the refactorings:

```
function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}
var shuffled = shuffle(catalog);
console.log(JSON.stringify(shuffled));
```
