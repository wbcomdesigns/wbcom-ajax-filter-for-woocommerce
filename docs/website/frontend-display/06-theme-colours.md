# Theme Colours (Token Bridge)

The plugin follows your store's theme instead of repainting it. Frontend components read colour through a single indirection layer of CSS custom properties, and those properties resolve down a chain of theme tokens before ever falling back to a fixed colour.

## How the Frontend Gets Its Colours

The stylesheet defines tokens on `:root` and the filter container:

| Token | Source chain (first hit wins) | Fallback |
|-------|-------------------------------|----------|
| `--wb-accent` | `--bx-color-accent` (BuddyX) -> `--reign-accent-color` (Reign) -> `--wp--preset--color--primary` -> `--wp--preset--color--accent` | `#157dfd` |
| `--wb-accent-fg` | fixed white | - |
| `--wb-bg` | `--bx-color-bg-page` -> `--reign-site-body-bg-color` -> `--wp--preset--color--base` | `#ffffff` |
| `--wb-surface` | `--bx-color-bg-elevated` -> `--reign-site-sections-bg-color` | `--wb-bg` |
| `--wb-text` | `--bx-color-text` -> `--reign-site-body-text-color` -> `--wp--preset--color--contrast` | `#1a1a1a` |
| `--wb-muted` | `--bx-color-fg-muted` -> `--reign-site-alternate-text-color` | derived from `--wb-text` |
| `--wb-border` | `--bx-color-border` -> `--reign-site-border-color` | derived from `--wb-text` |
| `--wb-link` | `--bx-color-link` -> `--reign-site-link-color` | `--wb-accent` |

BuddyX and Reign define different token vocabularies (`--bx-color-*` vs `--reign-*`), so the chain tries both, plus both theme.json preset slugs - Reign's accent slug is `primary`, BuddyX's is `accent` - before a literal. One theme change therefore lands across the whole filter UI.

**Owner colours win.** Colours you set on **Advanced -> Appearance** are printed as inline styles after the stylesheet, so they override the token fallbacks.

## Dark Mode

Dark mode is a root token override, never a per-component rule:

- On **BuddyX and Reign**, dark mode is driven by the theme's own `data-bx-mode` attribute on `<html>`. Because the tokens read through the theme's tokens, dark mode arrives for free - the plugin does not add its own dark class.
- On **themes with no tokens at all**, a `@media (prefers-color-scheme: dark)` block under `:root:not([data-bx-mode])` swaps only the literal fallbacks, following the operating system setting.

## Admin Side

wp-admin has no theme tokens - it has the user's own admin colour scheme. The admin CSS uses the same `--wb-*` vocabulary, but sourced from `--wp-admin-theme-color` (with a literal fallback), so the plugin's admin screens follow the colour scheme each user picks in **Users -> Profile**, and the same component styling works in both contexts.

## Customising Further

To pin your own colours, set the tokens on the filter container from your theme, or use the **Appearance** settings. Components never read theme tokens or hex values directly, so restyling one token restyles every component that uses it.

## Related Pages

- [Appearance Settings](../configuration/03-customization-settings.md) - owner colour controls.
- [Auto Render](03-auto-render.md) - where the frontend renders.