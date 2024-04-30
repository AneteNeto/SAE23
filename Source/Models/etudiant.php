<?php


namespace Source\Models;

use Source\Core\Model;

/**
 *
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
     * @param string $slug
     * @param string $columns
     * @return Person|null
     */
    public function findByNomPrenom(string $nom,string $prenom, string $columns = '*'): ?Etudiant
    {
        //return $this->find('slug = :s', "s={$slug}", $columns)->fetch();
        return $this->find(“Nom = :nom AND Prenom = :prenom”, “nom={$nom}& prenom={$prenom}”, $columns)->fetch();
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

    /**
     * @param array $data
     * @return array
     */
    public static function filter(array $data): array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (!is_null($value) ? filter_var($value, FILTER_SANITIZE_STRIPPED) : null);
        }
        return $filter;
    }
}