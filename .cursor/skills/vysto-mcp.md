# Vysto MCP

Remote MCP: `https://api.vysto.ai/api/v1/mcp/`

Authenticate with `Authorization: Bearer` and the `VYSTO_API_KEY` secret (`vys_...` from Dashboard → Developer → API & MCP). Do not write the key into the repo, pull requests, or chat.

First call every session: `get_vysto_playbook()`.

## Working tenant

API-key sessions keep a sticky working tenant. Do not pass `tenant_slug`. Call `list_tenant_workspaces()` once when you need the site list, and `select_working_tenant(slug)` only when the user names a client. Tell the user the `working_in` line from every tool response.

## Edits

- Custom HTML keeps `html`, `css`, and `js` separate. Allowlisted widget `<script src>` tags may stay in `html` or `script_html`.
- Prefer `list_page_sections` → `get_page_section` → `patch_section_field`.
- `update_page_layout(sections=...)` and `push_html_page` replace the whole page. Use them only when deletion is intentional.
- Header and footer copy belong in `shell_config`, not CSS.
- Publish with `publish=true` or `apply_page_changes`. On a security-scan block, call `get_publish_security_status`, fix the cited fields, and retry once.
- Prefer `create_upload_session` and `upload_to_session`. Remote MCP cannot read local paths.

## Anti-loop

One identical retry. A second failure means change strategy or ask the user. Do not resend the same blocked HTML.
