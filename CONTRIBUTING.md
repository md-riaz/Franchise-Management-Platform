# Contributing to Franchise Management Platform

Thank you for your interest in contributing to the Franchise Management Platform! This document provides guidelines and instructions for contributing to the project.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and professional environment for all contributors.

## How to Contribute

### Reporting Bugs

Before creating a bug report, please check the existing issues to avoid duplicates. When creating a bug report, include:

- A clear and descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Your environment (OS, PHP version, Laravel version)

### Suggesting Enhancements

Enhancement suggestions are welcome! Please provide:

- A clear and descriptive title
- Detailed description of the proposed feature
- Use cases and benefits
- Any potential drawbacks or considerations

### Pull Requests

1. **Fork the Repository**
   ```bash
   git clone https://github.com/md-riaz/Franchise-Management-Platform.git
   cd Franchise-Management-Platform
   ```

2. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make Your Changes**
   - Write clean, documented code
   - Follow the existing code style
   - Add tests for new features
   - Update documentation as needed

4. **Test Your Changes**
   ```bash
   php artisan test
   ```

5. **Commit Your Changes**
   ```bash
   git add .
   git commit -m "Add feature: your feature description"
   ```

6. **Push to Your Fork**
   ```bash
   git push origin feature/your-feature-name
   ```

7. **Create a Pull Request**
   - Provide a clear title and description
   - Reference any related issues
   - Wait for review and address feedback

## Development Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite

### Installation

1. Clone and install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure database in `.env`

4. Run migrations:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. Build assets:
   ```bash
   npm run dev
   ```

6. Start development server:
   ```bash
   php artisan serve
   ```

## Coding Standards

### PHP
- Follow PSR-12 coding standard
- Use type hints and return types
- Write descriptive variable and method names
- Add PHPDoc blocks for classes and methods

### Laravel
- Follow Laravel best practices
- Use Eloquent ORM for database operations
- Utilize Laravel's built-in features (validation, authentication, etc.)
- Keep controllers thin, use service classes for business logic

### Livewire
- Keep components focused and single-purpose
- Use wire:model for two-way binding
- Implement proper loading states
- Optimize for performance

### JavaScript
- Use ES6+ syntax
- Follow consistent formatting
- Comment complex logic
- Minimize direct DOM manipulation

### CSS/Tailwind
- Use Tailwind utility classes
- Keep custom CSS minimal
- Maintain responsive design
- Ensure accessibility

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Writing Tests
- Write tests for all new features
- Maintain existing test coverage
- Use factories for test data
- Test both happy paths and edge cases

## Documentation

- Update README.md for user-facing changes
- Document new features in relevant sections
- Include code examples where appropriate
- Keep API documentation up to date

## Database Migrations

- Never modify existing migrations
- Create new migrations for changes
- Use descriptive migration names
- Test both up() and down() methods

## Git Workflow

### Branch Naming
- `feature/description` - New features
- `bugfix/description` - Bug fixes
- `hotfix/description` - Critical fixes
- `refactor/description` - Code refactoring
- `docs/description` - Documentation updates

### Commit Messages
- Use present tense ("Add feature" not "Added feature")
- Use imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit first line to 72 characters
- Reference issues and pull requests when relevant

Example:
```
Add franchise onboarding workflow

- Implement multi-step onboarding form
- Add validation for franchise details
- Create welcome email notification

Closes #123
```

## Review Process

1. All pull requests require at least one approval
2. Automated tests must pass
3. Code must follow project standards
4. Documentation must be updated
5. No merge conflicts

## Questions?

If you have questions about contributing:
- Check existing documentation
- Search closed issues
- Open a new issue with the "question" label
- Reach out to maintainers

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

Thank you for contributing to the Franchise Management Platform!
