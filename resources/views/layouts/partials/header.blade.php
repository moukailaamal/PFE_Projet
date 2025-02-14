<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ .Page.Params.description | default .Site.Params.description | markdownify }}">
<meta name="author" content="{{ .Site.Params.authors }}">
<meta name="generator" content="Hugo {{ hugo.Version }}">

<title>{{ .Params.Title | markdownify }}</title>

<link rel="canonical" href="https://themesberg.com/product/tailwind-css/dashboard-windster">

{{ with .Params.robots -}}
<meta name="robots" content="{{ . }}">
{{- end }}

{{ partial "stylesheet" . }}
{{ partial "favicons" . }}
{{ partial "social" . }}
{{ partial "analytics" . }}
