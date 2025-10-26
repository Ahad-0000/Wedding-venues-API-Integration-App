import React from 'react';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { usePage, router, Head } from '@inertiajs/react';

const Index = () => {
    const props = usePage().props;
    const venues = props.venues ?? [];
    const message = props.message ?? null;
    const auth = props.auth ?? {};

    const handleApprove = (id) => {
        router.post(`/dashboard/venues/${id}/approve`, {}, {
            preserveScroll: true,
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this venue?')) {
            router.delete(route('dashboard.weddingvenues.destroy', id), {
                preserveScroll: true,
                
            });
        }
    };
    

    return (
        <Authenticated user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Wedding Venues</h2>}
        >
            <Head title="Wedding Venues" />
              

            <div className="p-6">
                <h1 className="text-2xl font-bold mb-4">Wedding Venues</h1>

                {message && (
                    <div className="bg-green-100 text-green-800 p-2 mb-4 rounded">
                        {message}
                    </div>
                )}

                <table className="w-full border text-left">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="p-2">Name</th>
                            <th className="p-2">Location</th>
                            <th className="p-2">Created At</th>
                            <th className="p-2">Price</th>
                            <th className="p-2">Capacity</th>
                            <th className="p-2">Status</th>
                            <th className="p-2">Created By</th>
                            <th className="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {venues.map((venue) => (
                            <tr key={venue.id} className="border-t">
                                <td className="p-2">{venue.name}</td>
                                <td className="p-2">{venue.location}</td>
                                <td className="p-2">{venue.created_at}</td>

                                <td className="p-2">{venue.price}</td>
                                <td className="p-2">{venue.min_capacity} - {venue.max_capacity}</td>
                                <td className="p-2">
                                    {venue.is_approved ? (
                                        <span className="text-green-600 font-semibold">Approved</span>
                                    ) : (
                                        <span className="text-red-600">Pending</span>
                                    )}
                                </td>
                                <td className="p-2">{venue.users[0]?.email ?? 'Unknown'}</td>
                                <td className="p-2">
                                    {!venue.is_approved && (
                                        <button
                                            onClick={() => handleApprove(venue.id)}
                                            className="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                        >
                                            Approve
                                        </button>
                                    )}
                                    <button
                                        onClick={() => handleDelete(venue.id)}

                                        className="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded ml-2"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </Authenticated>
    );
};

export default Index;
