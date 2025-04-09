<?php

namespace App\Policies;

use App\Models\TalkProposal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TalkProposalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view proposals
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TalkProposal $talkProposal): bool
    {
        return true; // All authenticated users can view individual proposals
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return true; 
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TalkProposal $talkProposal): bool
    {
        return $user->id === $talkProposal->user_id && $talkProposal->status === 'draft';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TalkProposal $talkProposal): bool
    {
        return $user->id === $talkProposal->user_id && $talkProposal->status === 'draft';
    }

    /**
     * Determine whether the user can review the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function review(User $user, TalkProposal $talkProposal): bool
    {
        return $user->role === 'admin' && $talkProposal->status === 'submitted';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TalkProposal $talkProposal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TalkProposal  $talkProposal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TalkProposal $talkProposal)
    {
        //
    }
}
