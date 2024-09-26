public function register(array $data)
    {
        return $this->firebaseAuth->createUser([
            'email' => $data['email'],
            'password' => $data['password'],
            'displayName' => $data['nom'] . ' ' . $data['prenom'],
        ]);
    }