document.addEventListener('DOMContentLoaded', () => {
    const pokemonGrid = document.getElementById('pokemon-grid');
    const generationSelect = document.getElementById('generation-select');
    const pokemonDetailModal = document.getElementById('pokemon-detail-modal');
    const pokemonDetail = document.getElementById('pokemon-detail');
    const closeModalButton = document.querySelector('.close-button');
    const backButton = document.getElementById('back-button');

    // Elementos de paginación
    const prevPageButton = document.getElementById('prev-page');
    const nextPageButton = document.getElementById('next-page');
    const pageInfoSpan = document.getElementById('page-info');

    // Variables de estado para la paginación
    let currentPage = 1;
    const itemsPerPage = 18; // Número de Pokémon por página
    let currentPokemonData = []; // Almacenará todos los Pokémon de la generación actual

    // Mapeo de generaciones a rangos de IDs de Pokémon
    const generationRanges = {
        'gen1': { startId: 1, endId: 151 },
        'gen2': { startId: 152, endId: 251 },
        'gen3': { startId: 252, endId: 386 }
    };

    /**
     * @brief Fetches all Pokemon data for a given generation from PokeAPI.
     * @param {string} generation - The generation key (e.g., 'gen1', 'gen2').
     */
    async function fetchAllPokemonsForGeneration(generation) {
        pokemonGrid.innerHTML = '<p>Cargando Pokémon...</p>';
        const { startId, endId } = generationRanges[generation];
        const totalPokemonInGen = endId - startId + 1;

        try {
            const response = await fetch(`https://pokeapi.co/api/v2/pokemon?offset=${startId - 1}&limit=${totalPokemonInGen}`);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const data = await response.json();
            const pokemonList = data.results;

            const detailedPokemonPromises = pokemonList.map(async (pokemon) => {
                const detailResponse = await fetch(pokemon.url);
                if (!detailResponse.ok) {
                    throw new Error(`Error HTTP al obtener detalles de ${pokemon.name}: ${detailResponse.status}`);
                }
                return detailResponse.json();
            });

            currentPokemonData = await Promise.all(detailedPokemonPromises);
            currentPage = 1;
            displayPage(currentPage);
            updatePaginationControls();
        } catch (error) {
            console.error("Error al obtener datos de Pokémon:", error);
            pokemonGrid.innerHTML = `<p class="error-message">Falló la carga de datos de Pokémon. Por favor, inténtalo de nuevo más tarde.</p>`;
            updatePaginationControls(true);
        }
    }

    /**
     * @brief Displays a specific page of Pokemon cards.
     * @param {number} page - The page number to display.
     */
    function displayPage(page) {
        pokemonGrid.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pokemonsToDisplay = currentPokemonData.slice(startIndex, endIndex);

        if (pokemonsToDisplay.length === 0 && currentPokemonData.length > 0) {
            if (currentPage > 1) {
                currentPage--;
                displayPage(currentPage);
            } else {
                pokemonGrid.innerHTML = '<p>No se encontraron Pokémon para esta página.</p>';
            }
            return;
        } else if (pokemonsToDisplay.length === 0 && currentPokemonData.length === 0) {
             pokemonGrid.innerHTML = '<p>No se encontraron Pokémon para esta generación.</p>';
             return;
        }

        pokemonsToDisplay.forEach(pokemon => {
            const pokemonCard = createPokemonCard(pokemon);
            pokemonGrid.appendChild(pokemonCard);
        });
        updatePaginationControls();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * @brief Creates a Pokemon card element.
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
     * @brief Updates the pagination buttons and page information.
     * @param {boolean} disableAll - If true, disables all pagination buttons.
     */
    function updatePaginationControls(disableAll = false) {
        const totalPages = Math.ceil(currentPokemonData.length / itemsPerPage);

        pageInfoSpan.textContent = `Página ${currentPage} de ${totalPages}`;

        prevPageButton.disabled = currentPage === 1 || disableAll;
        nextPageButton.disabled = currentPage === totalPages || totalPages === 0 || disableAll;

        if (totalPages === 0) {
            prevPageButton.style.display = 'none';
            nextPageButton.style.display = 'none';
            pageInfoSpan.style.display = 'none';
        } else {
            prevPageButton.style.display = 'inline-block';
            nextPageButton.style.display = 'inline-block';
            pageInfoSpan.style.display = 'inline-block';
        }
    }

    /**
     * @brief Displays detailed stats for a specific Pokemon in a modal.
     * @param {string} pokemonName - The name of the Pokemon to display details for.
     */
    async function showPokemonDetail(pokemonName) {
        pokemonDetail.innerHTML = '<p>Cargando detalles del Pokémon...</p>';
        pokemonDetailModal.style.display = 'flex';

        try {
            const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName.toLowerCase()}`);
            if (!response.ok) {
                throw new Error(`Error HTTP al obtener detalles de ${pokemonName}: ${response.status}`);
            }
            const pokemon = await response.json();

            pokemonDetail.innerHTML = `
                <h2>${pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1)} (#${String(pokemon.id).padStart(3, '0')})</h2>
                <img src="${pokemon.sprites.other['official-artwork'].front_default || pokemon.sprites.front_default}" alt="${pokemon.name}" style="max-width: 200px;">
                <p><strong>Tipo(s):</strong> ${pokemon.types.map(typeInfo => typeInfo.type.name.charAt(0).toUpperCase() + typeInfo.type.name.slice(1)).join(', ')}</p>
                <h3>Estadísticas:</h3>
                <ul>
                    ${pokemon.stats.map(statInfo => `<li><strong>${statInfo.stat.name.charAt(0).toUpperCase() + statInfo.stat.name.slice(1).replace('-', ' ')}:</strong> ${statInfo.base_stat}</li>`).join('')}
                </ul>
                <p><strong>Altura:</strong> ${pokemon.height / 10} m</p>
                <p><strong>Peso:</strong> ${pokemon.weight / 10} kg</p>
            `;
        } catch (error) {
            console.error("Error al obtener detalles del Pokémon:", error);
            pokemonDetail.innerHTML = `<p class="error-message">Falló la carga de detalles del Pokémon.</p>`;
        }
    }

    // --- Event Listeners ---

    // Event listener para el selector de generación
    generationSelect.addEventListener('change', (event) => {
        const selectedGeneration = event.target.value;
        fetchAllPokemonsForGeneration(selectedGeneration);
    });

    // Event listeners para los botones de paginación
    prevPageButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayPage(currentPage);
        }
    });

    nextPageButton.addEventListener('click', () => {
        const totalPages = Math.ceil(currentPokemonData.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayPage(currentPage);
        }
    });

    // Event listener para cerrar el modal con el botón X
    closeModalButton.addEventListener('click', () => {
        pokemonDetailModal.style.display = 'none';
    });

    // Event listener para el botón "Volver a la Lista" del modal
    backButton.addEventListener('click', () => {
        pokemonDetailModal.style.display = 'none';
    });

    // Cerrar el modal si el usuario hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target === pokemonDetailModal) {
            pokemonDetailModal.style.display = 'none';
        }
    });

    // Cargar Pokémon de la Generación I al iniciar la página
    fetchAllPokemonsForGeneration('gen1');
});