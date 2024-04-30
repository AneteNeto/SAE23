<?php


namespace Source\Models;

use Source\Core\Model;

/**
 * Class Etudiant
 */
class Etudiant extends Model
{
    /**
     * Person constructor.
     */
    public function __construct()
    {
        parent::__construct('Etudiant', ['idE'], ['Nom', 'Prenom','VilleDomicileP','VilleDomicileS','groupe']);
    }

    /**
     * @param string $nom
     * @param string $prenom
     * @param string $columns
     * @return Etudiant|null
     */
    public function findByName(string $nom,string $prenom, string $columns = '*'): ?Etudiant
    {
        return $this->find('Nom = :n AND Prenom=:p', "n={$nom}&p={$prenom}", $columns)->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        // Create slug
        $this->slug = str_slug($this->full_name);

        /** Update person */
        if (!empty($this->id)) {
            $personId = $this->id;

            if ($this->find('slug = :s', "s={$this->slug}")->count()) {
                $count = (new Person())
                    ->find('slug = :slug AND id != :id', "slug=%{$this->slug}%&id={$personId}")
                    ->count();

                $this->slug = $count ? str_slug($this->full_name . '-' . $count) : $this->slug;
            }
        }

        /** Create person */
        if (empty($this->id)) {
            if ($this->find('slug = :s', "s={$this->slug}")->count()) {
                $count = (new Person())
                    ->find('slug LIKE :slug', "slug=%{$this->slug}%")
                    ->count();

                $this->slug = str_slug($this->full_name . '-' . $count);
            }
        }

        return parent::save();
    }
}