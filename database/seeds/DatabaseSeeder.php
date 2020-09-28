<?php

use App\Board;
use App\Card;
use App\CardList;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        factory(User::class, 10)->create();

        $boardOne = Board::create([
            'title' => 'Groceries',
            'color' => 'teal',
            'owner_id' => 1,
        ]);

        $boardTwo = Board::create([
            'title' => 'Work',
            'color' => 'orange',
            'owner_id' => 2,
        ]);

        $boardThree = Board::create([
            'title' => 'Hobby',
            'color' => 'indigo',
            'owner_id' => 1,
        ]);

        $boards = collect([$boardOne, $boardTwo, $boardThree])->each(static function (Board $board) {
            $listOne = CardList::create([
                'title' => 'To-Do',
                'board_id' => $board->id,
            ]);

            $listTwo = CardList::create([
                'title' => 'In progress',
                'board_id' => $board->id,
            ]);

            $listThree = CardList::create([
                'title' => 'Done',
                'board_id' => $board->id,
            ]);

            collect([$listOne, $listTwo, $listThree])->each(static function (CardList $list) use ($board) {
                $order = 1;

                collect([
                    'Buy groceries',
                    'Take the dof for a walk',
                    'Pay the bills',
                    'Get the car fixed',
                    'Write novel',
                    'Buy pizza',
                    'Paint a picture',
                    'Create a course',
                ])
                ->random(random_int(2, 5))
                ->each(static function (string $task) use ($board, $list, &$order) {
                    $list->cards()->save(Card::make([
                        'title' => $task,
                        'owner_id' => $board->owner_id,
                        'order' => $order++,
                    ]));
                });
            });
        });
    }
}
