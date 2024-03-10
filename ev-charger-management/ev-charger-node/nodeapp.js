import axios from 'axios';

// Function to fetch station data from the API
async function fetchStationData() {
  try {
    const response = await axios.get('http://app:80/api/stations');

    return response.data;
  } catch (error) {
    console.error('Error fetching station data:', error.message);
    return [];
  }
}

// Function to group stations by company
function groupStationsByCompany(stations) {
  const groupedStations = {};

  stations.forEach(station => {
    if (!groupedStations[station.company_id]) {
      groupedStations[station.company_id] = [];
    }

    groupedStations[station.company_id].push(station);
  });

  return groupedStations;
}

async function main() {
  const stations = await fetchStationData();

  const groupedStations = groupStationsByCompany(stations);

  console.log('Stations grouped by company:', groupedStations);
}

main();