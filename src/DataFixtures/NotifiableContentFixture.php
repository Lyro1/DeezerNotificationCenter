<?php

namespace App\DataFixtures;

use App\Entity\DeezerContent\Album;
use App\Entity\DeezerContent\Podcast;
use App\Entity\DeezerContent\Track;
use App\Repository\DeezerContent\AlbumRepository;
use App\Repository\DeezerContent\PodcastRepository;
use App\Repository\DeezerContent\TrackRepository;
use Doctrine\Persistence\ObjectManager;

class NotifiableContentFixture extends AppFixtures {

    private TrackRepository $trackRepository;
    private AlbumRepository $albumRepository;
    private PodcastRepository $podcastRepository;

    public function __construct(TrackRepository $trackRepository,
                                AlbumRepository $albumRepository,
                                PodcastRepository $podcastRepository) {
        $this->trackRepository = $trackRepository;
        $this->albumRepository = $albumRepository;
        $this->podcastRepository = $podcastRepository;
    }

    public function load(ObjectManager $manager): void {
        $track = $this->createTrack('Madeon',
            'Love You Back',
            'https://e-cdn-images.dzcdn.net/images/cover/440481df936f90130fdd0a33c2a61b1c/264x264-000000-80-0-0.jpg',
            'https://www.deezer.com/en/track/1725075457');
        $manager->persist($track);
        $this->trackRepository->add($track);

        $track = $this->createTrack('Porter Robinson',
            'Everything Goes On',
            'https://e-cdn-images.dzcdn.net/images/cover/b3bc63af39a809b1b99acdbe8e5aba21/264x264-000000-80-0-0.jpg',
            'https://www.deezer.com/track/1799413337');
        $manager->persist($track);
        $this->trackRepository->add($track);

        $album = $this->createAlbum('Owl City',
        'Ocean Eyes',
        'https://e-cdn-images.dzcdn.net/images/cover/c923db2cb6698897426be066e01086c3/264x264-000000-80-0-0.jpg',
        'https://www.deezer.com/fr/album/390346');
        $manager->persist($album);
        $this->albumRepository->add($album);

        $podcast = $this->createPodcast('The Verge',
        'The Vergecast',
        'https://e-cdns-images.dzcdn.net/images/talk/9601681b478f5c4148ea0d9930b7f839/528x528-000000-80-0-0.jpg',
        'https://www.deezer.com/en/show/46077');
        $manager->persist($podcast);
        $this->podcastRepository->add($podcast);

        $manager->flush();
    }

    private function createTrack(string $artist, string $name, string $cover, string $link): Track {
        $track = new Track();
        $track->setName($name);
        $track->setArtist($artist);
        $track->setCover($cover);
        $track->setLink($link);
        return $track;
    }

    private function createAlbum(string $artist, string $title, string $cover, string $link): Album {
        $album = new Album();
        $album->setTitle($title);
        $album->setArtist($artist);
        $album->setCover($cover);
        $album->setLink($link);
        return $album;
    }

    private function createPodcast(string $artist, string $title, string $cover, string $link): Podcast {
        $podcast = new Podcast();
        $podcast->setTitle($title);
        $podcast->setArtist($artist);
        $podcast->setCover($cover);
        $podcast->setLink($link);
        return $podcast;
    }

}
