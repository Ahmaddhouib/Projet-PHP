// Configuration Tailwind CSS pour les dashboards (admin et randonneur)
// Mêmes couleurs que la page principale pour garder une cohérence visuelle
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      "colors": {
              "surface-variant": "#e4e0d8",
              "secondary-fixed-dim": "#d4ccbf",
              "on-primary-fixed": "#002110",
              "surface-bright": "#faf6f0",
              "on-error-container": "#690005",
              "inverse-primary": "#8ecf9e",
              "background": "#faf6f0",
              "inverse-on-surface": "#f5f0e8",
              "tertiary-container": "#c4a66a",
              "surface-container-lowest": "#ffffff",
              "secondary-fixed": "#f0e8db",
              "outline-variant": "#c4c8bc",
              "surface": "#faf6f0",
              "on-tertiary": "#ffffff",
              "on-primary": "#ffffff",
              "primary-fixed": "#c8e8d0",
              "on-primary-container": "#d8f0de",
              "inverse-surface": "#2e3230",
              "secondary-container": "#f0e8db",
              "primary-fixed-dim": "#8ecf9e",
              "on-secondary": "#ffffff",
              "on-secondary-container": "#5e5548",
              "on-secondary-fixed": "#1e1a13",
              "surface-container-highest": "#e4e0d8",
              "on-tertiary-container": "#554020",
              "on-tertiary-fixed-variant": "#554020",
              "surface-tint": "#4a7c59",
              "error": "#b83230",
              "surface-container": "#f0ece4",
              "secondary": "#6b6358",
              "tertiary": "#705c30",
              "on-error": "#ffffff",
              "on-background": "#2e3230",
              "primary-container": "#78a886",
              "error-container": "#ffdad8",
              "tertiary-fixed": "#f8e0a8",
              "on-tertiary-fixed": "#221a05",
              "tertiary-fixed-dim": "#dcc48e",
              "surface-container-low": "#f5f1ea",
              "on-surface-variant": "#4a4e4a",
              "surface-container-high": "#eae6de",
              "on-surface": "#2e3230",
              "surface-dim": "#dbd7cf",
              "outline": "#74796e",
              "on-secondary-fixed-variant": "#4a4538",
              "primary": "#4a7c59",
              "on-primary-fixed-variant": "#2a6038"
      },
      "borderRadius": {
              "DEFAULT": "0.5rem",
              "lg": "1rem",
              "xl": "1.5rem",
              "full": "9999px"
      },
      "fontFamily": {
              "headline": ["Literata"],
              "body": ["Nunito Sans"],
              "label": ["Nunito Sans"]
      }
    },
  },
}
