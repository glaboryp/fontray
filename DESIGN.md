---
name: Fontray
description: A calibrated instrument for identifying typefaces from images and PDFs
colors:
  bench-950: "#101214"
  bench-900: "#1c1f22"
  bench-800: "#24282c"
  bench-700: "#32373c"
  bench-600: "#454b52"
  bench-500: "#5f6870"
  bench-400: "#7f878e"
  bench-300: "#96a0a7"
  bench-200: "#b8bfc4"
  bench-100: "#d7dade"
  bench-50: "#f1f2f3"
  index-300: "#f4b969"
  index-400: "#edaa4c"
  index-500: "#e8952e"
  index-600: "#c97a1c"
  index-700: "#9c5f16"
  danger: "#d7625b"
  confirm: "#5fae82"
typography:
  display:
    fontFamily: "Archivo Variable, ui-sans-serif, system-ui, sans-serif"
    fontSize: "clamp(1.875rem, 3vw, 2.25rem)"
    fontWeight: 600
    lineHeight: 1.2
    letterSpacing: "-0.02em"
  headline:
    fontFamily: "Archivo Variable, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 600
    lineHeight: 1.3
  title:
    fontFamily: "Archivo Variable, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.125rem"
    fontWeight: 600
    lineHeight: 1.4
  body:
    fontFamily: "Archivo Variable, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.6
  label:
    fontFamily: "JetBrains Mono Variable, ui-monospace, SFMono-Regular, Menlo, Consolas, monospace"
    fontSize: "0.75rem"
    fontWeight: 500
    letterSpacing: "0.05em"
  mono-value:
    fontFamily: "JetBrains Mono Variable, ui-monospace, SFMono-Regular, Menlo, Consolas, monospace"
    fontSize: "0.875rem"
    fontWeight: 400
rounded:
  panel: "0.375rem"
  full: "9999px"
spacing:
  container-x: "1rem"
  section-y: "4rem"
  section-y-lg: "5rem"
components:
  button-primary:
    backgroundColor: "{colors.index-500}"
    textColor: "{colors.bench-950}"
    typography: "{typography.body}"
    rounded: "{rounded.panel}"
    padding: "10px 20px"
  button-primary-hover:
    backgroundColor: "{colors.index-400}"
  button-secondary:
    backgroundColor: "transparent"
    textColor: "{colors.bench-200}"
    rounded: "{rounded.panel}"
    padding: "8px 20px"
  button-secondary-hover:
    textColor: "{colors.bench-50}"
  nav-link:
    textColor: "{colors.bench-300}"
    typography: "{typography.body}"
  nav-link-hover:
    textColor: "{colors.index-400}"
---

# Design System: Fontray

## Overview

**Creative North Star: "Calibration Bench"**

Fontray reads as a precision instrument, not a SaaS upload form. The
whole surface is a dark graphite/steel bench: engraved panels, a circular
reticle/loupe as the literal drop target, calibration tick marks, and one
committed amber "index" accent that only appears where the instrument is
actively doing something — the reticle's active-drag glow, the primary
action, a confirmed-match lock pulse, step indices, and measured values.
Nothing on the page is a card, a bubble, or a soft ambient drop shadow;
depth comes from hairline borders, flat tonal steps between
`bench-950`/`bench-900`/`bench-800`, and a barely-there brushed-steel
grain (`.texture-steel`, 8% opacity, screen-blended) on chrome panels
(header, footer, modals, control panels).

This is the load-bearing world for the whole app. It is fully shipped on
`HomePage`, the shared `AppLayout` chrome (header, footer, loading
overlay), `Dashboard.vue`, `HistoryDashboard.vue`, `ResultsPage.vue`,
`ExamplesPage.vue`, `GuestLayout.vue`, everything under `Pages/Auth/`, and
`PrivacyPage.vue`/`TermsPage.vue` (a Read-mode surface: a single
`texture-steel` engraved panel holding hairline-divided sections, with the
document date set as a measured mono value). The old `--color-primary-*`
blue tokens have been removed from `app.css` entirely — there is no legacy
palette left to accidentally reach for.

**Key Characteristics:**
- Graphite/steel dark ground with a single committed amber index accent, never scattered as decoration.
- Archivo for all UI/display text; JetBrains Mono exclusively for measured/numeric values (step indices, contrast %, file size, timestamps, confidence).
- No cards, bubbles, or ambient drop shadows; flat panels separated by hairline borders and a subtle steel-grain texture.
- Two shapes only: the circular reticle/loupe (the signature instrument silhouette) and a single 6px "engraved panel" radius for every other rounded surface.
- Motion is motivated only — calibration needle sweep while processing, a lock-pulse glow on confirmed match, entrance reveals — never decorative looping animation.

## Colors

A near-monochrome graphite/steel scale carries the whole page; amber is the only chromatic color and is reserved for active/confirmed instrument states.

### Primary
- **Index Amber** (`#e8952e`, `index-500`): the single committed accent — primary CTA fill, active reticle border/glow, step-number index marks, confirmed-match lock pulse, and interactive link hover. Darker/lighter steps (`index-300` `#f4b969` through `index-700` `#9c5f16`) are used only for hover/active states of the same elements, never as a second independent accent.

### Neutral
- **Bench Black** (`#101214`, `bench-950`): header/footer/modal ground and the deepest recess (reticle interior, cropper canvas).
- **Bench Graphite** (`#1c1f22`, `bench-900`): the page's primary background and hero ground.
- **Bench Panel** (`#24282c`, `bench-800`): the next tonal step up, used for alternating section backgrounds (FAQ, usage-guide) and control panels (cropper toolbar, PDF chip).
- **Bench Steel** (`#32373c`–`#5f6870`, `bench-700`/`bench-600`/`bench-500`): borders, hairline dividers, reticle idle border.
- **Bench Fog** (`#7f878e`–`#96a0a7`, `bench-400`/`bench-300`): secondary/tertiary body text, placeholder icon strokes.
- **Bench Light** (`#b8bfc4`–`#f1f2f3`, `bench-200`/`bench-100`/`bench-50`): primary text on dark ground, headings.
- **Danger** (`#d7625b`): inline error text/icon only (upload/camera errors, form validation, destructive/error card headings). Retuned from an earlier `#d3534b` after the detector caught it failing 4.5:1 on the `bench-900` panels it also renders on (not just `bench-950`).
- **Confirm** (`#5fae82`): inline success text/icon only (upload success, "valid read" list markers).

### Named Rules
**The Single Index Rule.** Amber (`index-*`) is the only chromatic color on the page. It appears exclusively on things the instrument is actively doing: the primary action, the active/locked reticle, step indices, and measured highlights. It never decorates a static element.

## Typography

**Display/Body Font:** Archivo Variable (with ui-sans-serif, system-ui fallback)
**Label/Mono Font:** JetBrains Mono Variable (with ui-monospace, SFMono-Regular, Menlo, Consolas fallback)

**Character:** Archivo carries every heading and body sentence with a slightly tight, engineered tracking; JetBrains Mono is reserved strictly for values that were measured or counted, giving the page a dial-readout moment wherever a number appears.

### Hierarchy
- **Display** (600, `text-3xl md:text-4xl` / ~30–36px, tight leading, `-0.02em`–ish tracking): the hero headline only ("Sube una imagen. Lee la fuente exacta.").
- **Headline** (600, `text-2xl` / 24px): section titles ("Qué lee bien el instrumento", "Cómo funciona la medición", "Preguntas frecuentes").
- **Title** (600, `text-lg` / 18px): sub-block titles (step titles, modal headers, reticle idle-state title).
- **Body** (400, `text-sm`/`text-base`, `bench-300`/`bench-400` on dark ground): supporting copy, list detail text, FAQ answers.
- **Label** (500, `text-xs`, mono, uppercase, `0.05em` tracking): the two column headers in the usage-guide list ("LECTURAS VÁLIDAS" / "FUERA DE RANGO"); these are `h3` elements, not eyebrow text above another heading.

### Named Rules
**The Measured Value Rule.** Anything that is a number the instrument produced or counted — step index (`01`/`02`/`03`), contrast percentage, file size, confidence, timestamps — sets in JetBrains Mono with tabular figures. Everything else, including all headings and prose, sets in Archivo.

## Layout

Containers step down in width by content density: `max-w-7xl` for the header/footer bar, `max-w-5xl`/`max-w-4xl`/`max-w-3xl` for the three lower sections (how-it-works, usage-guide, FAQ), narrowing as line count per section drops. The hero uses an asymmetric two-column grid (`lg:grid-cols-[minmax(0,22rem)_1fr]`) — a fixed narrow copy column beside a flexible reticle column — rather than a centered marketing layout; it collapses to a single stacked column below `lg`. Section rhythm is generous and consistent: `py-16` mobile / `py-20` desktop (`md:`) for every content section. Sections are separated by flat background-tone changes (alternating `bench-900`/`bench-950`/`bench-800`) and hairline `border-t`/`border-b`, never by shadow or card edges.

## Elevation & Depth

The system is flat by default: no ambient or resting `box-shadow` anywhere. Depth is conveyed by stepped background tone (the `bench-950` → `bench-900` → `bench-800` ladder), 1px borders (`bench-700`/`bench-800`), and the `.texture-steel` brushed-metal grain overlay (a repeating background image at 8% opacity, `mix-blend-mode: screen`) applied to chrome panels — header, footer, modals, and the cropper's control panel — to read as engraved steel rather than a flat fill. The only `box-shadow` uses are motivated interaction glows tied to instrument state, not resting elevation: a soft amber ring around the reticle while a file is being dragged over it (`0 0 0 6px rgba(232,149,46,0.12)`), and a one-shot expanding "lock-pulse" ring animation on the reticle when a match is confirmed.

### Shadow Vocabulary
- **Drag-active glow** (`box-shadow: 0 0 0 6px rgba(232, 149, 46, 0.12)`): reticle border while a file is dragged over the drop target.
- **Lock-pulse** (`0 0 0 0 rgba(232,149,46,.45)` → `0 0 0 16px rgba(232,149,46,0)` over 0.9s): one-shot confirmation ring when the reticle locks after a successful selection/upload.

### Named Rules
**The No-Card Rule.** Surfaces are flat panels at rest, separated by hairline borders and tonal steps, never by `box-shadow`. Shadow only appears as a direct response to an instrument state change (drag-over, lock-confirm) — never as ambient elevation on a static card or button.

## Shapes

Two silhouettes only. The reticle/loupe — the hero drop target and the page's signature shape — is a true circle (`rounded-full`), echoing an optical viewfinder; nothing else on the page is circular except small icon badges that mirror it (the logo mark, the footer mark, the remove-file button). Every other rounded surface — buttons, image previews, modals, form panels, input chips — uses one flat "engraved panel" radius (`--radius-panel: 0.375rem` / 6px). There is no third radius value in use.

## Components

### Buttons
- **Shape:** engraved-panel radius (6px, `var(--radius-panel)`).
- **Primary:** amber fill (`index-500` → `index-400` on hover), `bench-950` text, `10px 20px`-scale padding. Used once per intent per page (file-select, identify, confirm-account-CTA in header) — no two CTAs share an intent.
- **Secondary/Ghost:** transparent fill, `bench-600` border (`bench-400` on hover), `bench-200`/`bench-300` text. Used for lower-emphasis actions (crop, cancel, orientation toggle) beside a primary button.
- **Disabled:** `bench-800` fill, `bench-300` text, no hover (retuned from an earlier `bench-700`/`bench-400` pairing that failed the 4.5:1 contrast floor).

### Cards / Containers
Fontray has no card component by design — see the No-Card Rule. Bounded surfaces (modals, control panels) use `bench-800`/`bench-900` fill, a `bench-700` 1px border, the engraved-panel radius, and `.texture-steel` grain instead of a shadow.

### Inputs / Fields
- **Style:** the visible "input" is the reticle drop target itself (a bordered circle, `bench-600` idle / `index-500` + glow on drag) plus a hidden native file input. The contrast slider (cropper) uses a thin `bench-700` track with `accent-index-500` thumb.
- **Focus/Error:** error text sets in `danger` with an inline X icon; success sets in `confirm` with an inline check icon, both as plain inline text/icon pairs, never a colored input border.

### Navigation
Header/footer are `texture-steel` `bench-950` bars with a 1px `bench-700` border. Nav links are `bench-300` body text, transitioning to `index-400` on hover — no underline, no active-state pill. The one nav CTA ("Crear cuenta") uses the primary-button treatment; all other links are plain text links.

### Reticle / Loupe (signature component)
The circular drop target is the hero's visual and functional center, not a button below a headline. Idle state shows 12 calibration ticks (radial `line` elements, majors every 3rd tick) around the circle rim; while processing, a mono needle sweeps continuously from center; on a successful match it fires the one-shot lock-pulse glow. This component is real SVG + CSS, never a stock image or icon-tile filler.

### Indexed Step List
The three "how it works" steps use a mono two-digit index (`01`/`02`/`03`) in `index-500` above each `title`-level heading, with a short amber tick mark above the number, echoing the reticle's own tick marks. This is a numbered/keyed-panel device specific to process steps, not a generic eyebrow label — it does not appear above any other heading on the page.

## Do's and Don'ts

### Do:
- **Do** keep amber (`index-*`) reserved for active instrument states — CTA, active/locked reticle, step index, measured values, link hover. Anything decorative in amber breaks the Single Index Rule.
- **Do** set every measured/counted number (step index, %, file size, timestamp) in JetBrains Mono; set everything else in Archivo.
- **Do** use the 6px engraved-panel radius for every rounded rectangle and `rounded-full` only for the reticle/loupe family of circular marks.
- **Do** separate sections and panels with hairline borders and tonal steps, adding `.texture-steel` grain to chrome panels instead of a drop shadow.
- **Do** keep motion motivated — needle sweep while processing, lock-pulse on confirm, scroll-entrance reveals — never a decorative infinite loop.

### Don't:
- **Don't** add card backgrounds, rounded bubbles, or soft ambient `box-shadow` to any resting surface; shadow only fires as a response to drag-over or lock-confirm state.
- **Don't** introduce a second accent color or let amber spread past the CTA/reticle/step-index/measured-value roles.
- **Don't** place a kicker/eyebrow label above a heading; the "how it works" step index and the usage-guide column labels are the only numbered/labeled devices, and both are load-bearing structural elements (a step counter, an `h3` itself) rather than decorative eyebrows — don't generalize either into a generic eyebrow-above-heading pattern elsewhere.
- **Don't** use glyph icon fonts; every icon on the page is inline SVG with explicit path data.
- **Don't** reach for the old blue `--color-primary-*` tokens or Instrument Sans — they've been removed from `app.css` entirely, there is nothing left to accidentally import.
