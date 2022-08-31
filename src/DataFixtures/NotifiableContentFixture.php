<?php

namespace App\DataFixtures;

use App\Entity\DeezerContent\Track;
use App\Repository\DeezerContent\TrackRepository;
use Doctrine\Persistence\ObjectManager;

class NotifiableContentFixture extends AppFixtures {

    private TrackRepository $trackRepository;

    public function __construct(TrackRepository $trackRepository) {
        $this->trackRepository = $trackRepository;
    }

    public function load(ObjectManager $manager): void {
        $track = $this->createTrack('Madeon',
            'Love You Back',
            'https://e-cdn-images.dzcdn.net/images/cover/440481df936f90130fdd0a33c2a61b1c/264x264-000000-80-0-0.jpg',
            'https://www.deezer.com/en/track/1725075457');
        $manager->persist($track);
        $this->trackRepository->add($track);

        $manager->flush();
    }

    private function createTrack(string $artist, string $name, string $cover, string $link): Track {
        $track = new Track();
        $track->setArtist($artist);
        $track->setName($name);
        $track->setCover($cover);
        $track->setLink($link);
        return $track;
    }

}
