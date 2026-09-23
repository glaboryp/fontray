# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Designers and developers who encounter a typeface in a professional
context — client work, a competitor or reference site, a printed piece, a
PDF brief — and need to identify it precisely enough to reuse or match it
in their own work.

## Product Purpose

Fontray lets a user upload an image or PDF containing text, crop it to
isolate the relevant area, and identify the typeface via automated
font-matching against the WhatFontIs API. Authenticated users can save and
revisit past identifications in a personal history.

## Positioning

Fontray is a professional identification workflow, not a bare API call: it
combines PDF-first-page extraction, an integrated crop-before-analyze
step, and a saved search history that a raw WhatFontIs lookup or a
one-shot competitor tool does not offer.

## Operating Context

- Users arrive with an image file or a PDF (a client brief, a screenshot,
  a photo of printed material).
- The uploaded PDF's first page is extracted to an image before analysis.
- The image is cropped (client-side, via an integrated cropper) before
  being submitted for identification.
- Identification calls the external WhatFontIs API and returns ranked
  font matches.
- Authenticated users can revisit prior identifications from a history
  view; anonymous users get a one-shot result.

## Capabilities and Constraints

- Font matching depends on the third-party WhatFontIs API; the identify
  endpoint is rate-limited (`throttle:identify`).
- PDF support covers the first page only.
- History requires an authenticated account (Laravel auth with email
  verification); anonymous use has no history.
- Deployed serverless on AWS (Bref/Laravel-bridge).
- Undecided: no accessibility standard has been formally established for
  this product yet.

## Brand Commitments

The name "Fontray" is the only fixed brand element. Logo, palette,
typography, and tone are explicitly open for the redesign — nothing else
about the current look is binding.

## Evidence on Hand

- The current Privacy Policy commits that uploaded images are used only
  for font analysis and are **not stored permanently**. This is a real,
  load-bearing product commitment (not just legal copy) that the redesign
  should carry forward, including as a visible trust cue where relevant.
- No named customers, testimonials, case studies, or press exist. Do not
  fabricate any in the redesign.

## Product Principles

- Privacy-first handling of user-uploaded material, made visible, not
  just stated in a legal page.
- The precision workflow (crop-before-analyze, PDF support) is core to
  the value proposition, not an incidental feature — it should read as
  the product's main mechanism, not be buried.
- Saved history is the return-visit value for professional users; treat
  it as a first-class surface, not an afterthought.
- Stays a free/indie tool: no monetization or enterprise-SaaS framing.
- Professional enough that a designer/developer trusts it with client
  material.

## Accessibility & Inclusion

No product-specific accessibility requirement has been established.
