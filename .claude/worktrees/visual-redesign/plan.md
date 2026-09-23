# Fontray — Rediseño visual (Impeccable + Taste)

## Objetivo

Rediseñar visualmente toda la app Fontray (landing + producto) explorando un
mundo visual nuevo (no un refinamiento del azul + Instrument Sans actual),
combinando dos skills de Claude Code:

- **Impeccable** — orquestador de diseño end-to-end, agnóstico de stack.
- **Taste** (`design-taste-frontend`) — checklist "anti-slop" para
  landing/marketing, usado como refuerzo puntual.

## Contexto actual

- Stack: Laravel 13 (PHP 8.4) + Vue 3 + Inertia.js v3 + Tailwind v4 +
  `vue-advanced-cropper`.
- No existe `DESIGN.md` ni `PRODUCT.md` todavía → Impeccable arranca en modo
  `init`.
- Superficies detectadas:
  - **Persuade** (marketing): `HomePage` (Hero, Upload, HowItWorks, FAQ).
  - **Operate** (producto): `Dashboard`, `HistoryDashboard`, `ResultsPage`,
    `ExamplesPage`.
  - **Read** (legal): `PrivacyPage`, `TermsPage`.
  - **Auth** (estilo Breeze): Login, Register, ForgotPassword,
    ResetPassword, ConfirmPassword, VerifyEmail.
- Paleta/tipografía actuales: azul `primary` (`#147dd9`) + Instrument Sans.
  Se tratan como evidencia/anti-referencia, no como base a preservar.

## Cómo se combinan las dos skills

- **Impeccable es el orquestador único para toda la app.** Cubre las 4
  superficies (Persuade/Operate/Read/Auth), tiene subagentes de assets,
  revisión final (`finish-reviewer`) y documentación (`documenter`), y no
  depende de un framework concreto.
- **Taste solo se aplica como checklist de refuerzo en la superficie
  Persuade (HomePage).** Su propio SKILL.md excluye explícitamente
  "dashboards, data tables, multi-step product UI". Sus defaults de
  *arquitectura de código* (React/Next, RSC, `motion/react`, `next/font`)
  no encajan con Vue/Inertia y **no se usan**; sí se usan sus reglas de
  *contenido y composición*: Design Read (Sección 0), dials de
  variance/motion/density (Sección 1), disciplina anti-default de
  tipografía/color (Sección 4.1-4.2), reglas duras de hero/CTA/nav/bento/
  eyebrows (Sección 4.7) y el copy self-audit (Sección 4.9), traducidas a
  Tailwind v4 + Vue en vez de a JSX.
- Antes de tocar código en cualquier superficie se relee `craft-floor.md`
  de Impeccable (paso 3 de su Setup): es el suelo de calidad no negociable.

## Fases

### Fase 0 — Preparación (bajo riesgo, reversible)

1. Crear rama `feat/visual-redesign`.
2. Guardar/mantener este `plan.md`.
3. Lanzar `impeccable init` para capturar `PRODUCT.md` (audiencia,
   propuesta de valor, marca, restricciones).

### Fase 1 — Dirección visual (checkpoint contigo antes de construir)

4. Lanzar `impeccable shape` (new-work) para toda la app: el look actual se
   trata como anti-referencia y se elige un mundo visual de reemplazo,
   generando un surface brief por superficie.
5. Para el surface brief de HomePage se incorpora el Design Read + dials de
   Taste.
6. **Checkpoint obligatorio:** se presenta la dirección visual elegida
   (paleta, tipografía, tono, mundo visual) antes de escribir código de
   producción en ninguna superficie.

### Fase 2 — Construcción por superficie, en este orden

Cada superficie se construye, se verifica una vez (desktop + mobile) y se
corrige en un solo batch — sin loops de pulido infinito.

7. **HomePage** (Hero, Upload, HowItWorks, FAQ) — Impeccable + checklist de
   Taste (hero cabe en el viewport inicial, máx. 4 elementos de texto en
   hero, no eyebrow en cada sección, no más de 2 secciones zigzag
   seguidas, CTAs sin intención duplicada, contraste de botones/formularios,
   imágenes reales en vez de placeholders con `<div>`).
8. **Flujo núcleo de producto** (`UploadSection` → `ResultsPage`) — modo
   Operate: escaneabilidad y consistencia priman sobre expresión.
9. **`Dashboard` + `HistoryDashboard`** — modo Operate.
10. **`ExamplesPage`** — a revisar si es Operate o Read al llegar a esta
    superficie.
11. **Páginas de Auth** — modo Operate, reutilizando el sistema ya fijado
    en fases anteriores, sin reinventar.
12. **`PrivacyPage` / `TermsPage`** — modo Read, pasada ligera.

### Fase 3 — Cierre

13. `impeccable audit` — accesibilidad, performance, responsive en toda la
    app.
14. `impeccable polish` — pasada final de calidad.
15. `impeccable document` — regenera `DESIGN.md` a partir de lo construido.
16. Ejecutar la suite existente (`pnpm test`, `pnpm test:e2e`, PHPUnit): el
    rediseño no debe romper comportamiento.
17. Pedir aprobación explícita antes de cualquier commit/push.

## Riesgos / decisiones abiertas

- `impeccable init` puede hacer preguntas de negocio (audiencia, propuesta
  de valor) que solo tú puedes responder.
- "Mundo visual nuevo" en toda la app es una decisión grande: el checkpoint
  de la Fase 1 es el punto de no retorno antes de tocar código real.
- No se hará commit/push de nada sin aprobación explícita, per convención
  habitual del usuario.

## Estado

- [ ] Fase 0 — Preparación
- [ ] Fase 1 — Dirección visual
- [ ] Fase 2 — Construcción por superficie
- [ ] Fase 3 — Cierre
