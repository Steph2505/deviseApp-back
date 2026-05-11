<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserAccessRight;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRepository extends ResourceRepository
{
    /**
     * Model repository
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $generatedPassword = Str::password(12);

        $user = DB::transaction(function () use ($data, $generatedPassword) {

            $user = $this->model->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'profil_id' => $data['profil_id'],
                'password' => Hash::make($generatedPassword),
            ]);

            if (!empty($data['access_rights'])) {
                foreach ($data['access_rights'] as $rightId) {
                    UserAccessRight::firstOrCreate([
                        'user_id' => $user->id,
                        'access_right_id' => $rightId,
                    ]);
                }
            }

            return $user;
        });

        Mail::to($user->email)->send(new UserCredentialsMail(
            name: $user->name,
            email: $user->email,
            password: $generatedPassword,
        ));

        return $user;
    }

    public function getAll()
    {
        $perPage = 15;
        return $this->model->with(['profils','accessRights'])->latest()->get();
    }

    public function findById(int $id)
    {
        return $this->model->with(['profils','accessRights'])->findOrFail($id);
    }

    public function update($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $user = $this->model->findOrFail($id);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'profil_id' => $data['profil_id'],
            ]);

            // Suppression anciens droits
            UserAccessRight::where('user_id', $user->id)->delete();

            // Réassignation des droits
            if (!empty($data['access_rights'])) {

                foreach ($data['access_rights'] as $rightId) {

                    UserAccessRight::create([
                        'user_id' => $user->id,
                        'access_right_id' => $rightId,
                    ]);
                }
            }

            return $this->findById($user->id);
        });
    }

    public function delete(int $id)
    {
        DB::transaction(function () use ($id) {

            UserAccessRight::where('user_id', $id)->delete();

            $this->model->findOrFail($id)->delete();
        });
    }
}
