<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user (login via seeder – no registration)
        $admin = User::factory()->create([
            'name'  => 'Alex Mercer',
            'email' => 'admin@devcraft.io',
            'password' => bcrypt('password'),
        ]);

        // Seed categories
        $this->call(CategorySeeder::class);

        // Fetch categories for articles
        $architecture = Category::where('name', 'Architecture')->first();
        $typescript   = Category::where('name', 'TypeScript')->first();
        $laravel      = Category::where('name', 'Laravel')->first();
        $react        = Category::where('name', 'React')->first();
        $devops       = Category::where('name', 'DevOps')->first();
        $career       = Category::where('name', 'Career')->first();

        // Seed sample articles matching the design
        $articles = [
            [
                'title'        => 'Decoupling Monoliths: A Pragmatic Approach to Microservices',
                'content'      => "When building modern applications, the shift from monoliths to microservices introduces a new class of problems. Network partitions are inevitable, latencies fluctuate, and downstream dependencies will eventually fail.\n\n## The Strangler Fig Pattern\n\nThe Strangler Fig pattern is one of the most effective strategies for incrementally migrating from a monolith to microservices. Rather than attempting a risky \"big bang\" rewrite, you gradually replace specific pieces of functionality with new applications and services.\n\nThe key principle is simple: as the new system grows, the old system shrinks — like a strangler fig tree slowly enveloping its host. Each new microservice intercepts a specific set of requests that were previously handled by the monolith.\n\n## Bounded Contexts\n\nDomain-Driven Design gives us the concept of bounded contexts, which are natural seams along which to decompose a monolith. Each bounded context encapsulates a specific area of business logic and has clear interfaces with other contexts.\n\nIdentifying these boundaries requires deep understanding of the business domain, not just the technical architecture. Start by mapping your domain events and identifying which parts of the system change together and which change independently.\n\n## Practical Steps\n\n1. **Identify the domain boundaries** in your existing monolith\n2. **Set up an API gateway** to route requests between the monolith and new services\n3. **Extract one bounded context** at a time, starting with the least coupled\n4. **Implement anti-corruption layers** to translate between old and new models\n5. **Monitor and validate** each extraction before proceeding to the next\n\nRemember: the goal isn't to have microservices everywhere. The goal is to have the right architecture for each part of your system.",
                'category_id'  => $architecture->id,
                'user_id'      => $admin->id,
                'status'       => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title'        => 'Advanced Generics: Unlocking Type Safety',
                'content'      => "TypeScript's type system is one of the most sophisticated in the mainstream programming world. Generics, in particular, unlock a level of type safety and code reuse that transforms how we build applications.\n\n## Conditional Types\n\nConditional types let you express non-uniform type mappings. They follow the pattern `T extends U ? X : Y`, which reads as: if T is assignable to U, the type resolves to X; otherwise, it resolves to Y.\n\n```typescript\ntype IsString<T> = T extends string ? 'yes' : 'no';\ntype A = IsString<string>;  // 'yes'\ntype B = IsString<number>;  // 'no'\n```\n\n## Mapped Types\n\nMapped types allow you to create new types by transforming each property in an existing type. Combined with template literal types, this becomes incredibly powerful.\n\n```typescript\ntype Readonly<T> = {\n  readonly [P in keyof T]: T[P];\n};\n\ntype Optional<T> = {\n  [P in keyof T]?: T[P];\n};\n```\n\n## The infer Keyword\n\nThe `infer` keyword lets you extract types within conditional type expressions. It's like pattern matching for types.\n\n```typescript\ntype ReturnType<T> = T extends (...args: any[]) => infer R ? R : never;\ntype UnpackPromise<T> = T extends Promise<infer U> ? U : T;\n```\n\nBy mastering these patterns, you can create APIs that are both flexible and type-safe, catching errors at compile time rather than runtime.",
                'category_id'  => $typescript->id,
                'user_id'      => $admin->id,
                'status'       => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title'        => 'Optimizing Eloquent Queries at Scale',
                'content'      => "Laravel's Eloquent ORM is beautifully expressive, but without careful attention, it can generate queries that bring your database to its knees.\n\n## The N+1 Problem\n\nThe most common performance issue with ORMs is the N+1 query problem. When you load a collection of models and then access a relationship on each one, Eloquent executes one query for the collection plus one query for each model's relationship.\n\n```php\n// BAD: N+1 queries\n\$posts = Post::all();\nforeach (\$posts as \$post) {\n    echo \$post->author->name; // Triggers a query for EACH post\n}\n\n// GOOD: Eager loading\n\$posts = Post::with('author')->get();\nforeach (\$posts as \$post) {\n    echo \$post->author->name; // No additional queries\n}\n```\n\n## Query Caching Strategies\n\nFor data that doesn't change frequently, query caching can dramatically reduce database load. Laravel's cache system integrates seamlessly with Eloquent.\n\n## Chunking Large Datasets\n\nWhen processing large datasets, use `chunk()` or `lazy()` to avoid loading everything into memory at once.\n\nThese techniques are essential for any Laravel application that needs to handle real-world traffic volumes.",
                'category_id'  => $laravel->id,
                'user_id'      => $admin->id,
                'status'       => 'published',
                'published_at' => now()->subDays(13),
            ],
            [
                'title'        => 'Rethinking State with Server Components',
                'content'      => "React Server Components represent a fundamental shift in how we think about rendering and state management in React applications. By moving rendering to the server, we can dramatically reduce the amount of JavaScript shipped to the client.\n\n## The Mental Model Shift\n\nTraditionally, React components render on the client. With Server Components, the rendering happens on the server, and only the result is sent to the client. This means:\n\n- No JavaScript bundle for server components\n- Direct database access from components\n- Reduced client-side state management complexity\n\n## When to Use Server vs. Client Components\n\nServer Components are ideal for:\n- Data fetching and display\n- Access to backend resources\n- Large dependencies that don't need interactivity\n\nClient Components are necessary for:\n- Event handlers (onClick, onChange)\n- useState, useEffect, and other hooks\n- Browser-only APIs\n\nThe key is to push client boundaries as far down the component tree as possible, keeping the majority of your app as Server Components.",
                'category_id'  => $react->id,
                'user_id'      => $admin->id,
                'status'       => 'published',
                'published_at' => now()->subDays(27),
            ],
            [
                'title'        => 'Zero-Downtime Deployments with GitHub Actions',
                'content'      => "Deploying without downtime is no longer a luxury — it's a baseline expectation. This guide walks through setting up blue-green deployments using GitHub Actions.\n\n## Blue-Green Architecture\n\nThe blue-green deployment strategy maintains two identical production environments. At any time, only one environment serves live traffic (let's call it \"blue\"). When you deploy a new version, you deploy to the idle environment (\"green\"), verify it's working correctly, and then switch traffic.\n\n## GitHub Actions Workflow\n\nHere's a simplified workflow that implements this pattern:\n\n```yaml\nname: Deploy\non:\n  push:\n    branches: [main]\n\njobs:\n  deploy:\n    runs-on: ubuntu-latest\n    steps:\n      - uses: actions/checkout@v4\n      - name: Deploy to staging slot\n        run: ./deploy.sh staging\n      - name: Health check\n        run: curl -f https://staging.example.com/health\n      - name: Swap slots\n        run: ./swap-slots.sh staging production\n```\n\n## Rollback Strategy\n\nThe beauty of blue-green is instant rollback. If the new version has issues, simply switch traffic back to the previous environment. No redeployment needed.\n\nCombined with feature flags and canary releases, this gives you confidence to deploy frequently and safely.",
                'category_id'  => $devops->id,
                'user_id'      => $admin->id,
                'status'       => 'published',
                'published_at' => now()->subDays(40),
            ],
            [
                'title'        => 'Building Resilient Distributed Systems in Node.js',
                'content'      => "When building modern applications, the shift from monoliths to microservices introduces a new class of problems. Network partitions are inevitable, latencies fluctuate, and downstream dependencies will eventually fail. Building resilient systems isn't about preventing failure; it's about embracing it and ensuring your application gracefully degrades rather than catastrophically collapsing.\n\n## The Fallacies of Distributed Computing\n\nBefore implementing technical solutions, we must acknowledge the fundamental truths of distributed systems. The network is not reliable, latency is not zero, and bandwidth is not infinite. Assuming otherwise leads to brittle architectures that crumble under production load.\n\n> **Key Consideration**\n> Always design for the worst-case scenario. If a database call usually takes 10ms, what happens when it takes 10,000ms? Does your service queue fill up? Do upstream clients timeout?\n\n## Implementing Circuit Breakers\n\nA circuit breaker acts as a safety valve. When a downstream service starts failing repeatedly, the breaker 'trips', immediately returning an error to the caller instead of wasting resources waiting for a timeout. This prevents cascading failures across the system.\n\n```typescript\nimport { CircuitBreaker } from 'opossum';\n\nconst options = {\n  timeout: 3000,\n  errorThresholdPercentage: 50,\n  resetTimeout: 30000\n};\n\nconst breaker = new CircuitBreaker(callExternalService, options);\nbreaker.fallback(() => 'Service currently unavailable.');\n```\n\nNotice how we configure timeouts and error thresholds. The `fallback` method ensures that even when the circuit is open, we provide a controlled response rather than crashing the process.",
                'category_id'  => $architecture->id,
                'user_id'      => $admin->id,
                'status'       => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create($articleData);
        }
    }
}
