# danielmallory-blog

Custom code for [danielmallory.blog](https://danielmallory.blog) (currently at
danielmalloryblog.wpcomstaging.com), deployed via WordPress.com GitHub Deployments.

## Structure

```
themes/    → deployed to /wp-content/themes
plugins/   → deployed to /wp-content/plugins
```

The repo root maps to `/wp-content` on the site (Simple deployment mode). Only the
files in this repo are copied on deploy — themes and plugins installed via wp-admin
are untouched.

## Local development

Requires Docker Desktop and Node.js.

```bash
npx @wordpress/env start   # site at http://localhost:8891 (admin/password)
npx @wordpress/env stop
```

`.wp-env.json` maps the plugins/themes in this repo into the local site and
activates them automatically.

## Deploying

Push to `main`. WordPress.com deploys automatically (if "Deploy changes on push"
is enabled) or via the Deploy button in Hosting → Deployments.
