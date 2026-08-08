# MadWorld News

MadWorld News is a role-based electronic magazine built with Laravel. It provides a public news website together with a collaborative editorial workflow where readers, writers, editors, and administrators have different responsibilities.

The project supports the complete lifecycle of an article: drafting, editorial review, rejection, publication, promotion as top news, updating, and deletion. Users may have more than one role at the same time, allowing a single account to participate in several parts of the workflow.

## Main features

- Public homepage with published articles and highlighted top stories
- Article browsing, pagination, subjects, images, and visit tracking
- Registration, login, password reset, and email verification
- Role-based dashboards and authorization
- Article drafting, submission, image upload, and editorial status tracking
- Editorial review, publication, rejection, unpublishing, and top-news management
- Reader comments
- User and role administration
- Contact form and email notifications
- Responsive interface built with Bootstrap, Tailwind CSS, Alpine.js, and Vite

## Roles and permissions

The application uses a many-to-many relationship between users and roles. A user can therefore be, for example, both a writer and an editor, or an administrator with editorial permissions.

### Reader

A reader can:

- Read published articles
- Comment on available articles
- View and manage their own comments from the dashboard

Newly registered users receive the `reader` role when that role has been created in the database. Registered users must verify their email address before accessing protected functionality.

### Writer

A writer can:

- Create articles
- Upload a featured image
- View their published, submitted, rejected, and draft articles in separate dashboard sections
- Edit and delete their own drafts and rejected articles
- Submit a draft or rejected article for editorial review

New articles are saved as drafts and are not visible to editors until the writer submits them. Once submitted, the writer can still view the article in **Submitted Articles**, but can no longer edit or delete it while editorial review is pending. Saving a newly created or edited article returns the user to the dashboard.

### Editor

A verified editor can:

- Review articles explicitly submitted by writers
- Publish or reject an article that is pending review
- Return a published article to its writer as a draft
- Mark an article as top news
- Remove the top-news status

Editors cannot edit or delete articles: only the writer who owns an article may alter its signed content. Unsubmitted drafts and rejected articles are not shown in the editor dashboard. Published articles remain available there so editors can unpublish them or manage their top-news status. Publishing or rejecting an article triggers an email notification to its writer.

If an account has both the `writer` and `editor` roles, ownership rules still apply. The user may edit or delete only their own drafts and rejected articles. Once one of their articles is submitted, it is locked in **Editorial Articles** just like any other submission; the user must reject it before revising it. A published article must first be unpublished before its writer can edit or delete it.

### Administrator

An administrator can:

- View registered users
- Open the details of an individual user
- Grant additional roles
- Remove roles

The `admin` role manages users and roles; it does not implicitly include writer or editor permissions. Because roles are independent and cumulative, an administrator who also needs to write or moderate content should additionally receive the `writer` or `editor` role.

## Editorial workflow

1. A verified writer creates an article.
2. The article is stored as an unpublished draft.
3. The draft remains private to its writer, who may edit, delete, or submit it.
4. Submitting the article moves it to **Submitted Articles**, locks writer-side editing and deletion, and makes it available to editors.
5. A verified editor may reject or publish the submitted article but cannot alter or delete its signed content.
6. Publishing records the publication timestamp, clears the submitted state, and makes the article publicly available.
7. Rejecting clears the submitted state and returns the article to the writer's **Rejected Articles** section. The editor no longer sees it as pending review.
8. The writer may edit, delete, or resubmit a rejected article. Resubmission locks it again until a new editorial decision is made.
9. Unpublishing returns a published article to the writer as a regular draft and also removes its top-news status.
10. The writer receives an email notification after publication or rejection.
11. An editor may promote a published article as top news or remove that status.

| State | Writer access | Editor access | Public access |
| --- | --- | --- | --- |
| Draft | View, edit, delete, submit | Hidden | Hidden |
| Submitted | View only | View, publish, reject | Hidden |
| Rejected | View, edit, delete, resubmit | Hidden | Hidden |
| Published | View | View, unpublish, manage top news | Visible |

Authorization is enforced on the server through Laravel policies and middleware. Hiding a button in the interface is not the only security measure: protected controller actions also verify the authenticated user's permissions and current article state. Submission, publication, rejection, unpublishing, and top-news changes use state-changing HTTP requests with CSRF protection rather than `GET` links.

The dashboard requires authentication and a verified email address. An authenticated user whose address is still unverified is redirected to the verification screen and shown a **Dashboard not available** message.

## Technology stack

### Backend

- PHP 8.2+
- Laravel 11
- Laravel Breeze for authentication scaffolding
- Laravel Eloquent ORM
- Laravel policies and middleware for authorization
- Laravel Mail with SMTP support
- MySQL 8

### Frontend

- Blade templates
- Bootstrap 5
- Tailwind CSS 3
- Alpine.js 3
- Vite 5

### Development environment

- Docker
- Docker Compose
- Composer 2
- Node.js 20

## Data and file storage

Article metadata is stored in MySQL. Uploaded images are stored on Laravel's public disk:

```text
storage/app/public/images/articles/
```

They are exposed by the application under:

```text
/storage/images/articles/{filename}
```

The editorial state is represented by the `submitted` and `rejected` flags together with the nullable `published_at` timestamp. The migration that introduces `submitted` defaults existing articles to `false`, so existing unpublished articles remain drafts until their writers submit them.

The Docker development configuration maps Laravel's public storage directory into `public/storage`, so uploaded images persist when containers are stopped or recreated.

Sessions, cache entries, and queued jobs are configured to use the database in the Docker environment.

## Local development with Docker

### Requirements

- Docker Engine
- Docker Compose

No local PHP, Composer, Node.js, or MySQL installation is required.

### 1. Create the environment file

```bash
cp .env.docker.example .env.docker
```

Review the database passwords and other local settings before continuing. `.env.docker` is ignored by Git and must not be committed.

### 2. Build the application image

```bash
docker compose build
```

### 3. Generate an application key

```bash
docker compose run --rm app php artisan key:generate --show
```

Copy the generated value into `.env.docker`:

```dotenv
APP_KEY=base64:generated-key
```

### 4. Start the database and run migrations

```bash
docker compose up -d db
docker compose run --rm app php artisan migrate
```

The roles required by the application are:

```text
reader
writer
editor
admin
```

They must exist before newly registered users can automatically receive the `reader` role.

### 5. Start the application

```bash
docker compose up -d
```

Open:

```text
http://localhost:8000
```

Vite runs on port `5173` and provides hot module replacement during development.

### Useful commands

```bash
# Follow application logs
docker compose logs -f app

# Run pending migrations
docker compose exec app php artisan migrate

# Open Laravel Tinker
docker compose exec app php artisan tinker

# Clear Laravel caches
docker compose exec app php artisan optimize:clear

# Stop the containers while retaining their data
docker compose stop

# Start existing containers again
docker compose start

# Remove containers while retaining named volumes
docker compose down
```

Running `docker compose down --volumes` also removes the MySQL and dependency volumes and therefore deletes the local database.

### Testing database safety

The editorial feature tests use Laravel's `RefreshDatabase` trait. Before running `php artisan test`, configure a dedicated testing database in `.env.testing` or `phpunit.xml`. Never point the test environment at the development or production database because the test suite may drop and recreate its tables.

## Email configuration

The application uses Laravel's SMTP mail transport for:

- Email verification
- Password reset messages
- Article publication notifications
- Article rejection notifications
- Contact form messages

For local testing, Mailtrap Email Sandbox can be configured in `.env.docker`:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME="mailtrap-smtp-username"
MAIL_PASSWORD="mailtrap-smtp-password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
ADMIN_EMAIL="admin@example.com"
```

After changing environment values, recreate the application container and clear cached configuration:

```bash
docker compose up -d --force-recreate app
docker compose exec app php artisan optimize:clear
```

Mailtrap Sandbox captures messages for inspection and does not deliver them to real recipients. A production deployment requires a verified sending domain and production SMTP credentials.

## Production considerations

The included Compose setup is intended for local development. Before publishing the application as a portfolio project or exposing it publicly:

- Set `APP_ENV=production` and `APP_DEBUG=false`
- Use strong, unique database credentials
- Keep MySQL inaccessible from the public internet
- Build frontend assets with `npm ci && npm run build`
- Serve Laravel through a production web server such as Nginx with PHP-FPM
- Configure HTTPS and secure session cookies
- Use a persistent public-storage volume or external object storage
- Configure a production SMTP provider and verified sender domain
- Run database migrations as a controlled deployment step
- Back up the database and uploaded article images
- Review dependency security notices before deployment

The Vite development server and `php artisan serve` should not be used as public-facing production servers.

## License

This project is based on the Laravel framework, which is open-sourced software licensed under the MIT license.
