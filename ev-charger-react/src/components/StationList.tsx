import React, { useEffect, useState, useRef } from 'react';
import { GoogleMap, LoadScript, Marker } from '@react-google-maps/api';
import axios from '../axiosConfig';
import '../StationList.css';

interface Station {
  id: number;
  name: string;
  latitude: number;
  longitude: number;
  address: string;
  company_id: number;
}

const mapContainerStyle = {
  width: '100%',
  height: '400px',
};

const libraries: ("places")[] = ['places'];

const StationList: React.FC = () => {
  const [stations, setStations] = useState<Station[]>([]);
  const [center, setCenter] = useState<{ lat: number, lng: number }>({ lat: 0, lng: 0 });
  const mapRef = useRef<google.maps.Map | null>(null);

  useEffect(() => {
    axios.get('/api/stations')
      .then((response) => {
        setStations(response.data);
        if (response.data.length > 0) {
          setCenter({
            lat: response.data[0].latitude,
            lng: response.data[0].longitude
          });
        }
      })
      .catch((error) => console.error('Error fetching data:', error));
  }, []);

  useEffect(() => {
    if (stations.length === 0 || !mapRef.current) return;

    const bounds = new google.maps.LatLngBounds();
    stations.forEach((station) => {
      bounds.extend(new google.maps.LatLng(station.latitude, station.longitude));
    });
    mapRef.current.fitBounds(bounds);
  }, [stations]);

  return (
    <div className="container">
      <div className="content">
        <table className="station-table">
          <thead>
            <tr className="station-table-header">
              <th>Name</th>
              <th>Address</th>
              <th>Latitude</th>
              <th>Longitude</th>
            </tr>
          </thead>
          <tbody>
            {stations.map((station) => (
              <tr key={station.id} className="station-table-row">
                <td>{station.name}</td>
                <td>{station.address}</td>
                <td>{station.latitude}</td>
                <td>{station.longitude}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      <LoadScript
        googleMapsApiKey="AIzaSyAdL9i_7V8mG6q8_KWa4-iVKKdDEH3RyCY"
        libraries={libraries}
      >
      <GoogleMap
        mapContainerStyle={mapContainerStyle}
        center={center}
        zoom={10}
        onLoad={(map) => {
          mapRef.current = map; 
        }}
        options={{ zoomControl: true }}
      >
      {stations.map((station) => (
        <Marker
          key={station.id}
          position={{ lat: station.latitude, lng: station.longitude }}
          title={station.name}
        />
      ))}
        </GoogleMap>
      </LoadScript>
    </div>
  );
};

export default StationList;
