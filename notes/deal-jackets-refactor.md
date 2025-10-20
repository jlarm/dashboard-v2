## 2025-10-01
- Added comments to the audits
- Next: Add the comments to the PDF's





# Branch: deal-jackets-refactor

---

## 2025-10-01
### ✅ Done
- DealJacketGroup created
- DealJacket created
- Create deal jacket group
- Create deal jacket
- Filter questions based on purchase and vehicle type
- When submitting the form, it does nothing
- Add more weight to some of the questions that get a "no"
- List out deal jacket groups

### ⏸ In Progress

### 🎯 Next
- Include "Flag as high risk" in the grade
- Generate PDF
- Include in dashboard stats

### 📝 Notes
- https://victor-ford.dashboard.test/audits/deal-jackets-new

```php
private function calculatePercentage(): int
{
    // 1. Early return if no responses
    if (empty($this->responses)) {
        return 0;
    }

    // 2. Initialize tracking variables
    $totalWeight = 0;      // Sum of all question weights
    $earnedWeight = 0;     // Weight earned from correct answers

    // 3. Loop through each response and its corresponding question
    foreach ($this->responses as $index => $response) {
      // Get the weight for this question (default: 1 if not set)
      $weight = $this->questions[$index]['weight'] ?? 1;
    
      // Add to total possible weight
      $totalWeight += $weight;
    
      // 4. Add weight if answer is 'yes' (passed)
      if (($response['answer'] ?? null) === 'yes') {
          $earnedWeight += $weight;
      }
    
      // 5. Penalty: Subtract 50% of weight if marked as high risk
      if ($response['high_risk'] === true) {
          $earnedWeight -= $weight * 0.5;
      }
    }

    // 6. Calculate final percentage
    // Round to nearest integer, return 0 if totalWeight is 0
    return $totalWeight > 0 ? (int) round(($earnedWeight / $totalWeight) * 100) : 0;
}
```

Example Calculation:

Let's say we have 3 questions:

| Question   | Weight | Answer | High Risk | Calculation              |
  |------------|--------|--------|-----------|--------------------------|
| Question 1 | 2      | yes    | false     | Earned: +2               |
| Question 2 | 1      | no     | true      | Earned: 0, Penalty: -0.5 |
| Question 3 | 3      | yes    | false     | Earned: +3               |

Calculation:
- Total Weight: 2 + 1 + 3 = 6
- Earned Weight:
    - Question 1: +2 (yes)
    - Question 2: 0 (no answer) - 0.5 (high risk penalty) = -0.5
    - Question 3: +3 (yes)
    - Total: 2 + (-0.5) + 3 = 4.5
- Percentage: (4.5 / 6) × 100 = 75%

Key Features:

1. Weighted Questions: Each question can have different importance (weight)
2. Pass/Fail Logic: Only 'yes' answers earn points
3. High-Risk Penalty: High-risk violations subtract 50% of that question's weight from the total earned weight
4. Safe Division: Prevents division by zero by checking if totalWeight > 0
5. Rounded Integer: Returns a whole number percentage

This method ensures that high-risk violations negatively impact the overall pass rate, even if other questions were answered correctly!
