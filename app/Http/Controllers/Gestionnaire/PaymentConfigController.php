<?php
namespace App\Http\Controllers\Gestionnaire;
use App\Http\Controllers\Controller;
use App\Models\ConfigurationMobileMoney;
use Illuminate\Http\Request;

class PaymentConfigController extends Controller
{
    public function index() { return view('gestionnaire.config.payment', ['operateurs' => ConfigurationMobileMoney::all()]); }
    public function update(Request $request, $id)
    {
        $config = ConfigurationMobileMoney::findOrFail($id);
        $config->update(['statut' => $request->statut]);
        return back()->with('success', 'Configuration mise à jour.');
    }
}