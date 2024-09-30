<?php
namespace App\Http\Controllers;

use App\Services\Interfaces\ReferentielServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReferentielRequest;

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
        $format = $request->formatFile;
        $data = $this->referentielService->getAllReferentiels($statut, $format);
        return response()->json($data);
    }

    public function addCompetenceToReferentiel($referentielId, Request $request){
        $data = $request->all();
        return response()->json($this->referentielService->addCompetenceToReferentiel($referentielId, $data));
    }

    public function store(StoreReferentielRequest $request)
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
    

    public function show($id, Request $request)
    {
        // $id = $request->query('id');
        $filtre = $request->query('filtre');
        $data = $this->referentielService->getReferentielById(strtoupper($id), $filtre);

        return response()->json($data);
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
        return response()->json($this->referentielService->getArchivedReferentiels());
    }
}