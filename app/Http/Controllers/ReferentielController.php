<?php
namespace App\Http\Controllers;

use App\Services\Interfaces\ReferentielServiceInterface;
use Illuminate\Http\Request;

class ReferentielController extends Controller
{
    protected $referentielService;

    public function __construct(ReferentielServiceInterface $referentielService)
    {
        $this->referentielService = $referentielService;
    }

    public function index(Request $request)
    {
        $statut = $request->query('statut'); 
        $data = $this->referentielService->getAllReferentiels($statut);
        return response()->json($data);
    }

    public function addCompetenceToReferentiel($referentielId, Request $request){
        $data = $request->all();
        return response()->json($this->referentielService->addCompetenceToReferentiel($referentielId, $data));
    }

    public function store(Request $request)
    {
        $ref = $request->all();
    
        // Vérifier si le fichier de photo est présent
        if ($request->hasFile('photo')) {
            $ref['photo'] = $request->file('photo')->store('photos/referentiels', 'public');
        } else {
            // Retourner une erreur si la photo n'est pas présente
            return response()->json(['message' => 'La photo est requise'], 400);
        }
    
        $data = $this->referentielService->createReferentiel($ref);
        return response()->json($data, 201);
    }
    

    public function show($id)
    {
        return response()->json($this->referentielService->getReferentielById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->referentielService->updateReferentiel($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->referentielService->deleteReferentiel($id));
    }

    public function archive()
    {
        // return response()->json($this->referentielService->getArchivedReferentiels());
    }
}