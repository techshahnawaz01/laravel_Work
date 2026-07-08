# Contributing

Keep changes small, clean, and tested.

## Code Standards

- Follow Laravel best practices.
- Keep controllers thin.
- Use form requests, services, and policies where needed.
- Write readable, PSR-12 code.

## Commit Format

Use Conventional Commits:

```text
type(scope): subject
```

Types:
- `feat`
- `fix`
- `docs`
- `style`
- `refactor`
- `perf`
- `test`
- `chore`

Scopes:
- `admin`
- `tenant`
- `task`
- `auth`
- `middleware`
- `db`
- `ui`

Examples:

```bash
feat(tenant): add task filters
fix(auth): handle tenant login redirect
docs(readme): shorten setup guide
```

## Before You Commit

- Run `php artisan test`
- Verify migrations still work
- Remove dead code and unused imports
- Update docs if behavior changed

## Pull Requests

1. Open a feature branch.
2. Make one logical change.
3. Add tests when behavior changes.
4. Include screenshots for UI work.
5. Keep the description short and clear.

