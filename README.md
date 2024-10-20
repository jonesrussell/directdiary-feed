# DirectDiary Feed

DirectDiary Feed is the content engine powering DirectDiary, an innovative entrepreneur hub and networking platform. It's built using Laravel, Inertia.js, and Vue 3, providing a robust foundation for delivering dynamic, engaging content to keep entrepreneurs connected and informed.

## Repository

https://github.com/jonesrussell/directdiary-feed

## About DirectDiary

DirectDiary is revolutionizing the way entrepreneurs connect, learn, and do business. Unlike traditional platforms that take a cut of transactions, DirectDiary empowers users to make direct deals without commissions, while providing a rich ecosystem of tools and resources for growth.

### Key Features

- **Commission-Free Direct Deals**: Facilitate business transactions without intermediary fees.
- **Daily Entrepreneurial Content**: Curated and original content to help users grow their businesses and skills.
- **Networking Tools**: Connect with like-minded entrepreneurs and potential business partners.
- **Resource Hub**: Access to tools, guides, and resources for business growth.
- **Engagement-Focused Platform**: Designed to keep users engaged and returning daily, increasing platform value.

## DirectDiary Feed Features

- User authentication and management (using Laravel Sanctum)
- Content management system for daily entrepreneurial insights
- Domain management for user profiles
- API for seamless integration with the main DirectDiary platform
- Single-page application (SPA) experience with Inertia.js and Vue 3

## TODO

- Consider implementing a robust domain parsing solution:
  - Evaluate the PHP Domain Parser library for accurate TLD and ccTLD handling.
  - Update the `DomainRepository::create()` method to use the chosen parsing library.
  - Note: This will add a new dependency to the project.
  - Example implementation:

    ```php
    use Pdp\Rules;
    use Pdp\Domain;

    class DomainRepository
    {
        // ... existing code ...

        public function create(array $data): Domain
        {
            $fullDomain = $data['name'];
            
            $rules = Rules::fromPath('/path/to/public_suffix_list.dat');
            $domain = Domain::fromIDNA2008($fullDomain);
            $result = $rules->resolve($domain);

            $data['name'] = $result->registrableDomain()->toString();
            $data['extension'] = $result->suffix()->toString();

            return Domain::create($data);
        }

        // ... existing code ...
    }
    ```

## Technologies

- PHP 8.3+
- Laravel 11+
- Inertia.js
- Vue 3
- Laravel Sanctum for API authentication
- Composer for PHP dependency management
- npm for JavaScript dependency management

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/jonesrussell/directdiary-feed.git
   cd directdiary-feed
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Copy the `.env.example` file to `.env` and configure your environment variables, especially the database connection.

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Run database migrations:
   ```
   php artisan migrate
   ```

7. (Optional) Seed the database with sample data:
   ```
   php artisan db:seed
   ```

8. Compile assets:
   ```
   npm run dev
   ```

9. Start the development server:
   ```
   php artisan serve
   ```

## Usage

After setting up the project, you can:

1. Register a new user account
2. Log in to the application
3. Manage content through the admin interface
4. Access content via API endpoints for integration with the main DirectDiary platform

## API Endpoints

(Note: Add specific API endpoints here once they are defined)

## Contributing

We welcome contributions that help make DirectDiary Feed even better for entrepreneurs. Please feel free to submit a Pull Request or open an Issue for discussion.

## License

DirectDiary Feed is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue in the GitHub repository or contact our support team at (add support email or link).

---

DirectDiary: Empowering entrepreneurs with knowledge, connections, and tools for success – every single day.
