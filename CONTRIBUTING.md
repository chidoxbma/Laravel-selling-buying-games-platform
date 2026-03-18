# 🤝 Contributing to GameVerse

First off, thank you for considering contributing to GameVerse! It's developers like you that make GameVerse such a great platform.

## 📋 Code of Conduct

This project and everyone participating in it is governed by our [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## 🚀 How Can I Contribute?

### **Reporting Bugs**

Before creating bug reports, please check the issue list as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

* **Use a clear and descriptive title**
* **Describe the exact steps which reproduce the problem**
* **Provide specific examples to demonstrate the steps**
* **Describe the behavior you observed after following the steps**
* **Explain which behavior you expected to see instead and why**
* **Include screenshots if possible**
* **Include your environment** (OS, PHP version, Laravel version)

### **Suggesting Enhancements**

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

* **Use a clear and descriptive title**
* **Provide a step-by-step description of the suggested enhancement**
* **Provide specific examples to demonstrate the steps**
* **Describe the current behavior and expected behavior**
* **Explain why this enhancement would be useful**

### **Pull Requests**

* Follow the PHP PSR-12 style guide
* Include appropriate test cases
* Update documentation as needed
* End all files with a newline
* Avoid platform-specific code

## 💻 Development Setup

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL 8.0+

### Getting Started

1. **Fork & Clone**
```bash
git clone https://github.com/yourusername/gameverse.git
cd gameverse
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**
```bash
# Update .env with your database credentials
php artisan migrate
php artisan db:seed
```

5. **Start Development**
```bash
php artisan serve
npm run dev
```

Visit: `http://localhost:8000`

## 📝 Commit Message Guidelines

* Use the present tense ("Add feature" not "Added feature")
* Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
* Limit the first line to 72 characters or less
* Reference issues and pull requests liberally after the first line

**Example:**
```
Add user email verification

- Implement email sending functionality
- Create verification token system
- Add middleware to check verification status

Closes #123
```

## 🎯 Coding Style

### PHP Code Style (PSR-12)

```php
<?php
// Use 4 spaces for indentation
namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Public methods first, then protected, then private
    public function index()
    {
        // Code here
    }

    // Add meaningful comments for complex logic
    protected function processPayment()
    {
        // Implementation
    }

    private function validateGame(Game $game)
    {
        // Implementation
    }
}
```

### JavaScript/Vue Code Style

```javascript
// Use 2 spaces for indentation
const handleSubmit = (formData) => {
  // Validate before submit
  if (!formData.email) {
    toast.error('Email is required');
    return;
  }

  // Process submission
  api.post('/games', formData);
};
```

### CSS/Tailwind Guidelines

```css
/* Use utility-first approach */
<div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg">
  <!-- Maintain order: layout, spacing, sizing, colors, effects -->
</div>
```

## 🧪 Testing

Write tests for all new features:

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=GameControllerTest

# Generate coverage report
php artisan test --coverage
```

**Test Example:**
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Game;

class GameCreationTest extends TestCase
{
    /** @test */
    public function user_can_create_game()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/store-jeu', [
                'nom' => 'Test Game',
                'prix' => 49.99,
                'plateforme_id' => 1,
            ]);

        $this->assertDatabaseHas('jeux', [
            'nom' => 'Test Game',
            'user_id' => $user->id,
        ]);
    }
}
```

## 📚 Documentation

When contributing features, please also update:

* `README.md` - If adding new features
* `SETUP.md` - If changing setup process
* Inline code comments - For complex logic
* API documentation - If modifying endpoints

## 🔒 Security

If you discover a security vulnerability, please email `security@gameverse.com` instead of using the issue tracker.

## ✅ Pull Request Process

1. Update the README.md with details of changes (UI, API, dependencies)
2. Increase version numbers in files and README.md following [SemVer](https://semver.org/)
3. Ensure all tests pass: `php artisan test`
4. Ensure code follows style guide: `composer run lint`
5. Create the Pull Request with a clear description

## 📦 Version Numbers

We follow Semantic Versioning:
- **MAJOR**: Breaking changes (1.0.0 → 2.0.0)
- **MINOR**: New features (1.0.0 → 1.1.0)
- **PATCH**: Bug fixes (1.0.0 → 1.0.1)

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [PHP-FIG Standards](https://www.php-fig.org/)
- [Git Best Practices](https://git-scm.com/book/en/v2)

## 🏆 Community

* Display a "Contributor" badge in your GitHub profile
* Join our [Discord Community](https://discord.gg/gameverse)
* Attend monthly contributor calls

---

Thank you for your interest in improving GameVerse! 🎉

Questions? Reach out to us:
- 📧 Email: `dev@gameverse.com`
- 💬 Discord: [GameVerse Dev Community](https://discord.gg/gameverse)
