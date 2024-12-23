<?php

namespace Database\Seeders;

use App\Filament\Admin\Resources\Shop\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Link;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Closure;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::raw('SET time_zone=\'+00:00\'');

        // Clear images
        Storage::deleteDirectory('public');

        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $adminUsers = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Demo User',
            'email' => 'admin@filamentphp.com',
            'role' => User::ROLE_ADMIN,
        ]));
        $adminUser = $adminUsers->first();
        $this->command->info('Admin user created.');

        // Buyer
        $this->command->warn(PHP_EOL . 'Creating buyer user...');
        $buyerUsers = $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Buyer User',
            'email' => 'buyer@filamentphp.com',
            'role' => User::ROLE_BUYER,
        ]));
        $buyerUser = $buyerUsers->first();
        $this->command->info('Buyer user created.');

        // Sellers
        $this->command->warn(PHP_EOL . 'Creating seller users...');
        $sellerUsers = $this->withProgressBar(2, function () {
            return User::factory(2)->create([
                'role' => User::ROLE_SELLER,
            ]);
        });
        $sellerUsers = $sellerUsers->all();
        $sellerUser1 = $sellerUsers[0];
        $sellerUser2 = $sellerUsers[1];
        $this->command->info('Seller users created.');

        // Shop
        $this->command->warn(PHP_EOL . 'Creating shop brands...');
        $brands = $this->withProgressBar(20, fn() => Brand::factory()->count(20)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        Brand::query()->update(['sort' => new Expression('id')]);
        $this->command->info('Shop brands created.');

        $this->command->warn(PHP_EOL . 'Creating shop categories...');
        $categories = $this->withProgressBar(20, fn() => ShopCategory::factory(1)
            ->has(
                ShopCategory::factory()->count(3),
                'children'
            )->create());
        $this->command->info('Shop categories created.');

        $this->command->warn(PHP_EOL . 'Creating shop customers...');
        $customers = $this->withProgressBar(50, fn() => Customer::factory(1)
            ->has(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info('Shop customers created.');

        // Create shop_products for the first seller
        $this->command->warn(PHP_EOL . 'Logging in first seller to create 20 shop products...');
        Auth::login($sellerUser1);

        $this->command->warn(PHP_EOL . 'Creating 20 shop products for first seller...');
        $productsSeller1 = $this->withProgressBar(20, fn() => Product::factory()->count(1)
            ->sequence(fn($sequence) => ['shop_brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->has(
                Comment::factory()->count(rand(10, 20))
                    ->state(fn(array $attributes, Product $product) => ['customer_id' => $customers->random(1)->first()->id]),
            )
            ->create());
        $this->command->info('20 shop products for first seller created.');

        Auth::logout();
        $this->command->info('First seller logged out.');

        // Create shop_products for the second seller
        $this->command->warn(PHP_EOL . 'Logging in second seller to create 30 shop products...');
        Auth::login($sellerUser2);

        $this->command->warn(PHP_EOL . 'Creating 30 shop products for second seller...');
        $productsSeller2 = $this->withProgressBar(30, fn() => Product::factory()->count(1)
            ->sequence(fn($sequence) => ['shop_brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->has(
                Comment::factory()->count(rand(10, 20))
                    ->state(fn(array $attributes, Product $product) => ['customer_id' => $customers->random(1)->first()->id]),
            )
            ->create());
        $this->command->info('30 shop products for second seller created.');

        Auth::logout();
        $this->command->info('Second seller logged out.');

        // Creating orders as previously
        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(50, fn() => Order::factory(1)
            ->sequence(fn($sequence) => ['shop_customer_id' => $customers->random(1)->first()->id])
            ->has(Payment::factory()->count(rand(1, 3)))
            ->has(
                OrderItem::factory()->count(rand(2, 5))
                    ->state(fn(array $attributes, Order $order) => ['shop_product_id' => $productsSeller1->random(1)->first()->id]),
                'items'
            )
            ->create());

        $this->command->info('Shop orders created.');

        foreach ($orders->random(rand(5, 8)) as $order) {
            Notification::make()
                ->title('New order')
                ->icon('heroicon-o-shopping-bag')
                ->body("{$order->customer->name} ordered {$order->items->count()} products.")
                ->actions([
                    Action::make('View')
                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                ])
                ->sendToDatabase($sellerUser1);
        }

        // Blog
        $this->command->warn(PHP_EOL . 'Creating blog categories...');
        $blogCategories = $this->withProgressBar(20, fn() => BlogCategory::factory(1)
            ->count(20)
            ->create());
        $this->command->info('Blog categories created.');

        $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
        $this->withProgressBar(20, fn() => Author::factory(1)
            ->has(
                Post::factory()->count(5)
                    ->has(
                        Comment::factory()->count(rand(5, 10))
                            ->state(fn(array $attributes, Post $post) => ['customer_id' => $customers->random(1)->first()->id]),
                    )
                    ->state(fn(array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random(1)->first()->id]),
                'posts'
            )
            ->create());
        $this->command->info('Blog authors and posts created.');

        $this->command->warn(PHP_EOL . 'Creating blog links...');
        $this->withProgressBar(20, fn() => Link::factory(1)
            ->count(20)
            ->create());
        $this->command->info('Blog links created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
