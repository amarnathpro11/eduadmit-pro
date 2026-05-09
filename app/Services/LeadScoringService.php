<?php

namespace App\Services;

use App\Models\Lead;

class LeadScoringService
{
    /**
     * Calculate the lead score based on profile data and interactions.
     * This simulates an AI model by weighing different factors.
     * In a production environment, this could call an external AI API (e.g., OpenAI)
     * or use a machine learning model trained on historical data.
     *
     * @param Lead $lead
     * @return int
     */
    public function calculateScore(Lead $lead): int
    {
        $score = 0;

        // 1. Profile Completeness (Weight: 30%)
        if (!empty($lead->email)) $score += 10;
        if (!empty($lead->phone)) $score += 10;
        if (!empty($lead->course_interested)) $score += 10;

        // 2. Source Quality (Weight: 20%)
        // Some sources are traditionally higher intent
        $highIntentSources = ['Website', 'Referral', 'Direct'];
        $mediumIntentSources = ['Facebook', 'Instagram', 'Social Media'];
        
        if (in_array($lead->source, $highIntentSources)) {
            $score += 20;
        } elseif (in_array($lead->source, $mediumIntentSources)) {
            $score += 10;
        }

        // 3. Status Weight (Weight: 30%)
        switch ($lead->status) {
            case 'Interested':
                $score += 20;
                break;
            case 'Converted':
                return 100; // Max score for converted
            case 'Lost':
                return 0;   // Min score for lost
            default:
                $score += 5; // New or pending leads start lower
                break;
        }

        // 4. Interaction Quality (Simulated AI Analysis of Notes)
        // If the counselor has left detailed notes, it often implies higher engagement
        if (!empty($lead->notes)) {
            $length = strlen($lead->notes);
            if ($length > 100) {
                $score += 20; // Detailed notes imply serious interest
            } elseif ($length > 20) {
                $score += 10;
            }
        }

        // Cap the score at 100
        return min($score, 100);
    }

    /**
     * Simulate AI sentiment analysis on lead communication.
     * 
     * @param string $message
     * @return int Score boost
     */
    public function analyzeSentiment(string $message): int
    {
        $positiveWords = ['interested', 'looking forward', 'join', 'fee', 'admission', 'course'];
        $negativeWords = ['not interested', 'expensive', 'cancel', 'wrong number'];

        $scoreBoost = 0;
        $messageLower = strtolower($message);

        foreach ($positiveWords as $word) {
            if (str_contains($messageLower, $word)) {
                $scoreBoost += 5;
            }
        }

        foreach ($negativeWords as $word) {
            if (str_contains($messageLower, $word)) {
                $scoreBoost -= 10;
            }
        }

        return $scoreBoost;
    }
}
