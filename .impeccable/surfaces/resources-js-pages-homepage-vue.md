---
version: 1
slug: "resources-js-pages-homepage-vue"
primary_target: "resources/js/Pages/HomePage.vue"
related_targets: []
---

# Surface brief — HomePage (Persuade)

## Scope and visitor mode

Mode: **Persuade**. Route: `/` (`resources/js/Pages/HomePage.vue`, composed of
`HeroSection`, `UploadSection`, `HowItWorksSection`, `FaqSection`). This
surface establishes the replacement visual world for the whole app; every
later surface inherits it.

Audience/job: a designer or developer who saw a typeface in client
material and needs to identify it precisely enough to trust the result.
Within seconds they must believe: this tool measures precisely and won't
leak my client's file. Primary action: drop/upload an image (or PDF) and
start identification.

## Direction contract

THESIS: Identifying a font is an act of instrumental measurement — reading
a calibrated dial — never a generic upload-and-spin. Refuses the
card-grid/dropzone SaaS default this category always ships.

OWN-WORLD: Graphite/steel ground (`#1c1f22` base, `#d7dade` steel
highlight), one committed amber calibration accent (`#e8952e`) that owns
full regions at focal moments (the hero reticle glow, a confirmed-match
state, the primary action) rather than scattering as decoration.
Display/UI type: Archivo. Every measured value (confidence, calibration
numbers, timestamps) sets in JetBrains Mono with tabular figures. Chrome
reads as engraved steel panels, reticle crosshairs, and calibrated arcs —
never cards, bubbles, or soft drop shadows. Results are numbered/indexed
like a keyed panel, not a loose grid. A confirmed match locks and lights
like an armed instrument control, a real tactile confirmation state, not
a static checkmark.

STORY: The visitor understands in seconds that this measures rather than
guesses, and trusts it with client material because it looks and behaves
like a calibrated instrument. They act by dropping an image directly onto
the bench and reading the dial.

FIRST VIEWPORT: A dark instrument bench fills the viewport. Its visual and
functional center is a large lit reticle/loupe viewfinder — the drop
target itself, not a separate button below a headline. The headline reads
as an engraved plate label above the bench, not centered marketing copy.
A calibrated arc motif frames where results will populate once an image is
measured. Each candidate match, once returned, sits beside the user's own
cropped input for a visible side-by-side comparison, not a bare score.

FORM: Assigned direction "Calibration Bench" (grounded candidate 6 of 7:
forensic match report, audio-signal matcher, radar identification,
museum-provenance card, security-scan review, **precision-instrument
panel [assigned]**, variable-font specimen). Seed key `19a2fbdc`.
Fused against the dealt catalog challengers on audience identification and
product clarity: none beat the assigned direction on both axes.
"Specimen Wall" (variable-font specimen) held audience identification only
— kept as a named full alternate, not built. Declined challengers donated:
a numbered/indexed results panel (from the ekiben-kiosk challenger), the
tactile lit-confirmation state (from the drum-machine challenger), and the
side-by-side candidate/reference comparison (from the hand-processed-film
challenger).

FINISH: unreviewed and undocumented is unfinished; this build ends with
the finish review, the verdict, DESIGN.md, and every shipping raster
carrying its provenance.

## Constraints for this surface

- Color strategy: Restrained (neutral graphite/steel base, one committed
  accent) — the accent commits at page scale in the reticle/CTA/confirm
  states, never as a scattered highlight. This strategy carries to Operate
  surfaces later; only the Persuade surfaces may push it harder locally.
- Hero must fit the initial viewport: headline max 2 lines, subtext ≤20
  words, primary action visible without scrolling.
- Max 3 text elements in the hero stack (headline, subtext, CTA); no
  trust micro-strip or feature bullets inside the hero.
- No kicker/eyebrow label above any heading anywhere on the page (craft
  floor hard ban — the heading carries its own weight).
- No two CTAs on the page may share the same intent (one label for
  "start identifying").
- No more than 2 consecutive sections using the same left-image/right-text
  layout family; HowItWorks and FAQ must use materially different
  structures from each other and from the hero/upload bench.
- Button and form contrast must pass WCAG AA (4.5:1 body, 3:1 large text)
  against the graphite ground — audit the amber accent specifically, it is
  the riskiest combination.
- No div-based fake screenshots or generic icon-tile filler; the
  reticle/dial chrome IS the visual, built as real UI, not a stock image.
- Motion is motivated only: the calibration needle/arc sweeping to a
  confidence position, a lock-in glow on confirmed match, entrance reveals
  on scroll. No decorative infinite-loop animation.

## Unresolved decisions (left to the build)

- Exact copy for headline/subtext/CTA label (must satisfy the copy
  self-audit: no invented claims, no fabricated stats).
- Whether the hero reticle shows a live sample crop immediately or an
  idle/empty calibrated-dial state before first upload.
- Icon set to standardize on (Phosphor or Tabler recommended; pick one and
  keep it project-wide once chosen).
