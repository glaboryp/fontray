---
model: claude-haiku-4-5-20251001
---

# /push

Incorpora cambios de main mediante rebase y hace push de la rama actual a origin.

## Pasos a seguir

### 1. Verificar estado

```bash
git status --short && git branch --show-current
```

Si hay cambios sin commitear (staged o unstaged), avisa y detente — ejecuta `/commit` primero.

Ramas protegidas: si la rama actual es `main` avisa y detente.

### 2. Comprobar cambios en main

```bash
git fetch origin main
git log HEAD..origin/main --oneline
```

Muestra los commits nuevos si los hay, o indica que main está al día.

### 3. Confirmar

```
Rama   : <rama-actual>
Nuevos en main: <n commits o "ninguno">
Acción : rebase sobre origin/main → push
```

Pide confirmación. Si cancela, detente.

### 4. Rebase y push

```bash
git rebase origin/main
```

Si hay conflictos: lista los ficheros afectados, indica que resuelva y ejecute `git rebase --continue`, y detente.

Si el rebase va bien:

```bash
git push origin <rama-actual>
# Si la rama no existe en remoto:
git push --set-upstream origin <rama-actual>
```

Nunca uses `--force` salvo que el usuario lo pida explícitamente, y en ese caso advierte del riesgo.

### 5. Resumen final

```
✅ Push completado: <rama> → origin/<rama>
💡 Cuando estés listo: /create_pr
```