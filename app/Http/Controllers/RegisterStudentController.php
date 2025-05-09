<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class RegisterStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'enrollment' => ['required', 'string', 'size:9', 'regex:/^VP\d{7}$/i', 'unique:users'],
            'course' => ['required', Rule::in([
                'Informática',
                'Mecatrônica',
                'Edificações',
                'Engenharia Civil',
                'Engenharia Elétrica',
                'Física',
                'Sistemas de Informação',
            ])],
        ])->validate();

        $nameParts = explode(' ', trim($input['name']));
        $firstName = strtolower($nameParts[0]);
        $lastName = strtolower(end($nameParts));
        $email = "{$firstName}.{$lastName}@aluno.ifsp.edu.br";
    
        $enrollmentDigits = substr($input['enrollment'], 2);
        $password = $lastName . $enrollmentDigits;

        User::create([
            'name' => $input['name'],
            'email' => $email,
            'password' => Hash::make($password),
            'enrollment' => $input['enrollment'],
            'course' => $input['course'],
        ]);

        return redirect()->route('admin.students');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
