---
model: claude-haiku-4-5-20251001
---

# /create_pr

Crea una Pull Request en Github desde la rama actual.

## Pasos a seguir

### 1. Detectar rama

```bash
git branch --show-current
```

Verifica que la rama existe en remoto:
```bash
git ls-remote --heads origin <rama>
```
Si no existe, avisa: hay que hacer `/push` primero y detente.

### 2. Analizar y generar mensaje de la pr

Analiza la rama y genera un mensaje para la pr, en inglés

### 3. Confirmar datos de la PR

Muestra los valores y permite editarlos:
```
Título : <summary>
Destino: main
Desc   : <descripción o vacío>
```

Una vez confirmado por el usuario, crea la pr en Github

### 4. Resumen final

```
✅ PR creada: <título>
🔀 <rama-actual> → <rama-destino>
🔗 <url-de-la-pr>
```

---

## Reglas

- Si no hay commits nuevos respecto a la rama destino, avisa al usuario.
- Si la rama destino no existe en remoto, avisa antes de crear la PR.
- Nunca añadas `Co-authored-by: Claude` ni `Generated with Claude Code` ni similar.
- Cada frase o bullet del cuerpo de la PR va en una sola línea, sin saltos de línea manuales a mitad de frase (nada de cortar cada 8-10 palabras). Deja que el texto haga wrap de forma natural.