# Contributing Guidelines

Thank you for contributing to this multi-tenant Laravel application. This document provides guidelines for clean, consistent commits and contributions.

## Code of Conduct

- Be respectful and professional
- Write clean, maintainable code
- Follow Laravel best practices
- Test your changes thoroughly
- Update documentation as needed

## Commit Guidelines

We follow [Conventional Commits](https://www.conventionalcommits.org/) specification.

### Commit Message Format

```
<type>(<scope>): <subject>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes
- `refactor`: Code refactoring
- `perf`: Performance improvements
- `test`: Adding or updating tests
- `chore`: Build process or dependencies

**Scopes:**
- `admin`: Admin panel changes
- `tenant`: Tenant portal changes
- `task`: Task management
- `auth`: Authentication
- `middleware`: Middleware updates
- `db`: Database changes
- `ui`: Frontend changes

### Examples

```bash
feat(tenant): add user registration
fix(task): resolve validation error
docs(readme): update installation
refactor(middleware): simplify tenant identification
```

### Best Practices

1. Atomic commits (single logical change)
2. Present tense
3. No periods at end
4. Capitalize subject
5. Keep under 50 characters
6. Explain why in body

## Pull Request Process

1. Create feature branch
2. Write clean code (PSR-12)
3. Test thoroughly
4. Commit with convention
5. Push and create PR
6. Include description and screenshots

## Branch Naming

```
feat/feature-name
fix/bug-description
docs/update-readme
refactor/component-name
```

## Pre-Commit Checklist

- [ ] Code follows PSR-12
- [ ] All tests pass
- [ ] No console errors
- [ ] Migrations work
- [ ] No sensitive data
- [ ] Documentation updated
- [ ] Commit follows convention
- [ ] Changes are atomic

## Testing

```bash
php artisan test
```

## Documentation

- Update README.md for features
- Add code comments for complex logic
- Include usage examples

## What Not to Commit

- .env files
- API keys
- Database credentials
- Tenant data/schemas
- IDE configs
- Vendor directories
- Log files

## Code Review

- Self-review first
- At least one approval
- All CI checks pass
- No merge conflicts

## Release Process

1. Update version numbers
2. Update CHANGELOG.md
3. Create git tag: `git tag v1.x.x`
4. Push tags: `git push --tags`
5. Create GitHub release

## Bug Reports

Include:
- Laravel/PHP/PostgreSQL versions
- Steps to reproduce
- Expected vs actual behavior
- Screenshots/errors

## Feature Requests

- Describe the problem
- Propose solution
- Explain benefits
- Provide examples

---

**Thank you for contributing!**
</parameter>
<parameter name="task_progress">
- [x] Update .gitignore with comprehensive rules
- [x] Create CONTRIBUTING.md with commit guidelines
- [ ] Create deployment checklist
- [ ] Prepare final submission checklist
- [ ] Verify all documentation is complete
</parameter>
</write_to_file>