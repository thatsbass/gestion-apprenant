<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Facade\PromotionFacade as Promotion;
use Carbon\Carbon;

class PromotionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Example validation for 'libelle' (check if it is unique)
        if ($attribute === 'libelle') {
            $existingPromotion = Promotion::where('uid', $value)->first();
            if ($existingPromotion) {
                $fail("Le libellé de la promotion doit être unique.");
            }
        }

        // Validation for 'date_debut' and 'date_fin'
        if ($attribute === 'date_debut' || $attribute === 'date_fin') {
            $this->validateDates($value, $attribute, $fail);
        }
    }

    /**
     * Validate the start and end dates of the promotion.
     *
     * @param  mixed $value
     * @param  string $attribute
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected function validateDates(mixed $value, string $attribute, Closure $fail): void
    {
        // Convert dates to Carbon instances
        try {
            $dateValue = Carbon::parse($value);
        } catch (\Exception $e) {
            $fail("Le format de la date n'est pas valide.");
            return;
        }

        // Custom rules for date_debut and date_fin
        if ($attribute === 'date_debut') {
            // Validate that the start date is not in the past
            if ($dateValue->isPast()) {
                $fail('La date de début ne peut pas être dans le passé.');
            }
        }

        if ($attribute === 'date_fin') {
            // Assume `date_debut` is available in the request
            $dateDebut = request('date_debut');
            if ($dateDebut) {
                $dateDebutValue = Carbon::parse($dateDebut);
                if ($dateValue->lessThan($dateDebutValue)) {
                    $fail('La date de fin doit être postérieure à la date de début.');
                }
            }
        }
    }
}
