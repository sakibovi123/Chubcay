import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import Header from '@/Components/Main/Header';
import PricingCard from '@/Components/Main/PricingCard';
import InputError from '@/Components/InputError';


export default function Edit({user}) {
    
    // const { auth } = usePage().props;

    const {data, setData, post, processing, errors, reset} = useForm({
        first_name: user.first_name || '',
        last_name: user.last_name || '',
        // email: '',
        phone: user.phone || '',
        country: user.country || '',
        city: user.city || '',
        current_password: '',
        new_password: '',
    });

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const patchUser = (e) => {
        e.preventDefault()

        post(route('profile.update'), {
            // onSuccess: reset(),
            onError: (errors) => console.log(errors)
        })
    }

    return (
        // <AuthenticatedLayout
        //     user={auth.user}
        //     header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>}
        // >
        //     <Head title="Profile" />

        //     <div className="py-12">
        //         <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdateProfileInformationForm
        //                     mustVerifyEmail={mustVerifyEmail}
        //                     status={status}
        //                     className="max-w-xl"
        //                 />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <UpdatePasswordForm className="max-w-xl" />
        //             </div>

        //             <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        //                 <DeleteUserForm className="max-w-xl" />
        //             </div>
        //         </div>
        //     </div>
        // </AuthenticatedLayout>
        
        <div className="w-full container md:mx-auto">
            <Head title='Profile' />
            <Header />

            <div className="w-full md:my-[4rem] p-3">
                <div className="md:flex items-start justify-between gap-5">
                    <div className="bg-white md:w-[30%] my-3 md:my-0 border rounded p-2">
                        <h2 className="p-2 font-extrabold">Active package: <span>{user.first_name}</span></h2>
                        <div className="rounded p-2 bg-blue-600 text-center text-white font-extrabold">
                            23h:32m:36s left
                        </div>
                        <div className="w-full flex justify-center">
                            <button className="text-center w-[50%] bg-blue-600
                                p-2 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                            >
                                Update or Sell
                            </button>
                        </div>
                        
                    </div>

                    <div className="p-2 md:w-[70%] bg-white border rounded">
                        <h1 className="text-2xl font-bold p-2">Profile</h1>
                        <form onSubmit={patchUser}
                             className="w-full p-2 flex flex-col items-start gap-3" action="">
                            <label htmlFor="Email">Email</label>
                            <input type="email" disabled className="bg-red-200 w-full rounded border-gray-200"
                                defaultValue={user.email} />
                            <InputError message={errors.email} className="mt-2" />

                            <label htmlFor="FirstName">First Name</label>
                            <input onChange={(e) => setData('first_name', e.target.value)}
                             type="text" className="w-full rounded border-gray-200"
                                value={data.first_name} />
                            <InputError message={errors.first_name} className="mt-2" />

                            <label htmlFor="LastEmail">Last Name</label>
                            <input onChange={(e) => setData('last_name', e.target.value)}
                             type="text" className="w-full rounded border-gray-200"
                             value={data.last_name} />
                            <InputError message={errors.last_name} className="mt-2" />

                            <label htmlFor="Country">Country</label>
                            <input onChange={(e) => setData('country', e.target.value)}
                                type="text" className="w-full rounded border-gray-200"
                                     value={data.country} />
                            <InputError message={errors.country} className="mt-2" />

                            <label htmlFor="Phone">Phone</label>
                            <input onChange={(e) => setData('phone', e.target.value)}
                                 type="text" className="w-full rounded border-gray-200" value={data.phone} />
                            <InputError message={errors.phone} className="mt-2" />

                            <label htmlFor="City">City</label>
                            <input onChange={(e) => setData('city', e.target.value)}
                                 type="text" className="w-full rounded border-gray-200" value={data.city} />
                            <InputError message={errors.city} className="mt-2" />

                            <label htmlFor="Current Password">Current Password</label>
                            <input onChange={handleChange} name="current_password"
                                 type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                            <InputError message={errors.current_password} className="mt-2" />

                            <label htmlFor="New Password">New Password</label>
                            <input name="new_password" onChange={handleChange}
                                 type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                            <InputError message={errors.new_passwoqrd} className="mt-2" />


                            <button type="submit"
                                 className="w-full text-center bg-blue-600 rounded shadow-md p-2 text-white font-bold">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    );
}
