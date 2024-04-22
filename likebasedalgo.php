<?php

class LikeBasedRecommendationSystem {
    private $userLikes = [];

    public function addLike($userId, $itemId) {
        if (isset($this->userLikes[$userId])) {
            $this->userLikes[$userId][] = $itemId;
        } else {
            $this->userLikes[$userId] = [$itemId];
        }
    }

    public function getRecommendations($userId) {
        $userLikes = isset($this->userLikes[$userId]) ? $this->userLikes[$userId] : [];
        $recommendations = [];

        foreach ($this->userLikes as $otherUser => $likedItems) {
            if ($otherUser != $userId) {
                $commonLikes = array_intersect($userLikes, $likedItems);
                if (!empty($commonLikes)) {
                    $recommendations = array_merge($recommendations, array_diff($likedItems, $commonLikes));
                }
            }
        }

        return array_unique($recommendations);
    }
}


$recommendationSystem = new LikeBasedRecommendationSystem();

$recommendationSystem->addLike(1, 'movie_A');
$recommendationSystem->addLike(1, 'movie_B');
$recommendationSystem->addLike(2, 'movie_B');
$recommendationSystem->addLike(2, 'movie_C');
$recommendationSystem->addLike(3, 'movie_A');
$recommendationSystem->addLike(3, 'movie_C');

$userId = 1;
$recommendations = $recommendationSystem->getRecommendations($userId);

echo "Recommendations for User $userId: " . implode(', ', $recommendations) . "\n";
?>
