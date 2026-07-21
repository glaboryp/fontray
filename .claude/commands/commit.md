---
model: claude-haiku-4-5-20251001
---

# /commit

Selecciona ficheros, genera un mensaje de commit en inglés, pide confirmación y commitea sin añadir Claude como co-author.

## Pasos a seguir

### 1. Detectar cambios

```bash
git status --short
```

### 2. Selector de ficheros

Muestra la lista y pregunta cuáles incluir:

```
Ficheros con cambios:
  1. src/Controller/UserController.php  [M]
  2. src/Service/AuthService.php        [M]
  3. config/services.yaml               [M]

¿Cuáles incluir? (ej: 1,2 / todos)
```

### 3. git add

```bash
git add <ficheros seleccionados>
```

### 4. Analizar y generar mensaje

```bash
git diff --cached
git branch --show-current
```

Genera un mensaje en formato **Conventional Commits**:

```
<type>: <short description in imperative mood>

<optional body: what and why, not how. 72 chars max per line.>
```

Tipos válidos: `feat`, `fix`, `refactor`, `chore`, `docs`, `test`, `style`, `perf`

Reglas:
- Primera línea: máximo 72 caracteres
- Imperativo: `add`, `fix`, `update` — no `added`, `fixed`
- Todo en inglés
- **Sin ninguna línea `Co-authored-by`**

### 5. Confirmar

Muestra el mensaje y ofrece:
- **Aceptar** → commitea
- **Editar** → el usuario escribe el mensaje
- **Cancelar** → aborta

### 6. Commit

```bash
git commit -m "<subject>" -m "<body si existe>"
```

Muestra el hash resultante.

---

## Reglas

- Sin issue key en la rama → genera el mensaje sin scope.
- Nunca uses `-a` ni `--all`.
- Nunca añadas `Co-authored-by: Claude` ni similar.