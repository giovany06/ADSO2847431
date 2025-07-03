document.addEventListener('DOMContentLoaded', () => {
    const iconicPokemonGrid = document.getElementById('iconic-pokemon-grid');
    const pokemonDetailModal = document.getElementById('pokemon-detail-modal');
    const pokemonDetail = document.getElementById('pokemon-detail');
    const closeModalButton = document.querySelector('.close-button');
    const backButton = document.getElementById('back-button');

    // Pokémon icónicos para la sección de historia (se usarán sus nombres para buscar detalles)
    const iconicPokemonNames = [
        "pikachu", "charizard", "blastoise", "venusaur", "snorlax", "eevee",
        "mewtwo", "lugia", "ho-oh", "rayquaza", "groudon", "kyogre",
        "lucario", "greninja", "zekrom", "reshiram", "dialga", "palkia"
    ];

    /**
     * @brief Creates a Pokemon card element.
     * This function is duplicated here as it's needed in both script.js and history_script.js.
     * In larger projects, this would be in a shared utility file.
     * @param {Object} pokemon - The Pokemon data object.
     * @returns {HTMLElement} The created div element for the Pokemon card.
     */
    function createPokemonCard(pokemon) {
        const pokemonCard = document.createElement('div');
        pokemonCard.classList.add('pokemon-card');
        pokemonCard.dataset.pokemonName = pokemon.name;

        const pokemonId = `#${String(pokemon.id).padStart(3, '0')}`;
        const pokemonName = pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1);
        const pokemonTypes = pokemon.types
            .map(typeInfo => typeInfo.type.name.charAt(0).toUpperCase() + typeInfo.type.name.slice(1))
            .join(', ');
        const pokemonImage = pokemon.sprites.other['official-artwork'].front_default || pokemon.sprites.front_default;

        pokemonCard.innerHTML = `
            <img src="${pokemonImage}" alt="${pokemonName}" loading="lazy">
            <p class="pokemon-id">${pokemonId}</p>
            <h3>${pokemonName}</h3>
            <p class="pokemon-types">Tipo(s): ${pokemonTypes}</p>
        `;
        pokemonCard.addEventListener('click', () => showPokemonDetail(pokemon.name));
        return pokemonCard;
    }

    /**
     * @brief Displays detailed stats for a specific Pokemon in a modal.
     * Now fetches and displays a brief description (flavor text).
     * @param {string} pokemonName - The name of the Pokemon to display details for.
     */
    async function showPokemonDetail(pokemonName) {
        pokemonDetail.innerHTML = '<p>Cargando historia del Pokémon...</p>';
        pokemonDetailModal.style.display = 'flex'; // Usar 'flex' para centrado con CSS

        try {
            // Fetch basic Pokemon data to get ID for species data
            const pokemonResponse = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName.toLowerCase()}`);
            if (!pokemonResponse.ok) {
                throw new Error(`Error HTTP al obtener datos básicos de ${pokemonName}: ${pokemonResponse.status}`);
            }
            const pokemon = await pokemonResponse.json();

            // Fetch Pokemon species data to get flavor text
            const speciesResponse = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${pokemon.id}/`);
            if (!speciesResponse.ok) {
                throw new Error(`Error HTTP al obtener datos de especie de ${pokemonName}: ${speciesResponse.status}`);
            }
            const speciesData = await speciesResponse.json();

            // Find a flavor text entry, prioritizing Spanish, then English
            let description = 'Descripción no disponible.';
            const spanishEntries = speciesData.flavor_text_entries.filter(entry => entry.language.name === 'es');
            const englishEntries = speciesData.flavor_text_entries.filter(entry => entry.language.name === 'en');

            if (spanishEntries.length > 0) {
                // Get the latest Spanish entry (or just the first available)
                description = spanishEntries[0].flavor_text.replace(/\n/g, ' ').replace(/\f/g, ' ');
            } else if (englishEntries.length > 0) {
                // Fallback to English if no Spanish entry is found
                description = englishEntries[0].flavor_text.replace(/\n/g, ' ').replace(/\f/g, ' ');
            }

            pokemonDetail.innerHTML = `
                <h2>${pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1)} (#${String(pokemon.id).padStart(3, '0')})</h2>
                <img src="${pokemon.sprites.other['official-artwork'].front_default || pokemon.sprites.front_default}" alt="${pokemon.name}" style="max-width: 200px;">
                <h3>Una Breve Historia:</h3>
                <p>${description}</p>
                <p><strong>Tipo(s):</strong> ${pokemon.types.map(typeInfo => typeInfo.type.name.charAt(0).toUpperCase() + typeInfo.type.name.slice(1)).join(', ')}</p>
            `;
        } catch (error) {
            console.error("Error al obtener detalles del Pokémon:", error);
            pokemonDetail.innerHTML = `<p class="error-message">Falló la carga de la historia del Pokémon.</p>`;
        }
    }

    /**
     * @brief Fetches and displays iconic Pokemon in the history section.
     */
    async function fetchAndDisplayIconicPokemon() {
        iconicPokemonGrid.innerHTML = '<p>Cargando personajes icónicos...</p>';
        try {
            const iconicPokemonPromises = iconicPokemonNames.map(async (name) => {
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${name.toLowerCase()}`);
                if (!response.ok) {
                    throw new Error(`Error al obtener detalles de ${name}: ${response.status}`);
                }
                return response.json();
            });

            const loadedIconicPokemon = await Promise.all(iconicPokemonPromises);
            iconicPokemonGrid.innerHTML = ''; // Limpiar mensaje de carga
            loadedIconicPokemon.forEach(pokemon => {
                const pokemonCard = createPokemonCard(pokemon); // Reutilizar la función de creación de tarjeta
                iconicPokemonGrid.appendChild(pokemonCard);
            });
        } catch (error) {
            console.error("Error al cargar personajes icónicos:", error);
            iconicPokemonGrid.innerHTML = `<p class="error-message">No se pudieron cargar los personajes icónicos.</p>`;
        }
    }

    // --- Event Listeners para el modal en history.html ---

    // Event listener para cerrar el modal con el botón X
    closeModalButton.addEventListener('click', () => {
        pokemonDetailModal.style.display = 'none';
    });

    // Event listener para el botón "Volver a la Lista" del modal (aquí sirve para cerrar el modal)
    backButton.addEventListener('click', () => {
        pokemonDetailModal.style.display = 'none';
    });

    // Cerrar el modal si el usuario hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target === pokemonDetailModal) {
            pokemonDetailModal.style.display = 'none';
        }
    });

    // Cargar los personajes icónicos al iniciar la página de historia
    fetchAndDisplayIconicPokemon();
});